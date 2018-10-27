<?php
//    ________                          ___  ____         _
//   |_   __  |                        |_  ||_  _|       / |_
//   | |_ \_| _ .--.  .---.  _ .--.    | |_/ /    _ .--.`| |-'
//   |  _| _ [ `/'`\]/ /__\\[ `.-. |   |  __'.   [ `/'`\]| |
//  _| |__/ | | |    | \__., | | | |  _| |  \ \_  | |    | |,
// |________|[___]    '.__.'[___||__]|____||____|[___]   \__/

/**
 * Class Yabancı Dizi Bot PHP / Class
 * @author Eren Kurt (ErenKrt)
 * @mail kurteren07@gmail.com
 * @İnstagram ep.eren
 * @date 27.10.2018
 */
 
namespace eperen;

$GLOBALS["baseurl"]= "https://sandbox-api.ininal.com";

class giris{

  public $lapi_auth;
  public $api_auth=array();

   function __construct($api_key,$api_secret) {
      $this->lapi_auth= "Basic ".base64_encode($api_key.":".$api_secret);
   }

    function curl($uri,$token,$method='GET',$data=''){
      $ch = curl_init($GLOBALS['baseurl'].$uri);
      if($method=="GET"){
      curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Date:'.gmdate('D, d M Y H:i:s T'), 'Authorization:'.$token, 'Content-Type:application/json', 'Language:TR'));
      if($method=="POST"){
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      }
      $response = curl_exec($ch);
      if($response === FALSE){
          return false;
          die(curl_error($ch));
      }
      curl_close($ch);
      return $responseData = json_decode($response, TRUE);
  }

  public function hatayakala($data){
    if(($data["httpCode"]!=200) && ($data["httpCode"]!=201) ){
      echo "<hr>Dönüt Kodu: <b>".$data["httpCode"]."</b><br>Açıklama: ".$data["description"]."<br><ul><li>Hata Kodu: <b>".$data["response"]["errorCode"]."</b></li><li>".$data["response"]["errorDescription"]."</li></ul><hr>";
      return false;
    }else{
      return true;
    }
  }

  function giris(){
    $uri= "/v2/oauth/accesstoken";
    $cdata= $this->curl($uri,$this->lapi_auth,"POST");
    if($this->hatayakala($cdata)){
      $this->api_auth["type"]=$cdata["response"]["tokenType"];
      $this->api_auth["token"]= $cdata["response"]["accessToken"];
      return $this->api_auth;
    }
  }
}

class kullanici{
  public $api_auth;

  function __construct($token) {
     $this->api_auth= $token["type"]." ".$token["token"];
  }

  function curl($uri,$token,$method='GET',$data=''){
    $ch = curl_init($GLOBALS['baseurl'].$uri);
    if($method=="GET"){
    curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
    }
    if($method=="PUT"){
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Date:'.gmdate('D, d M Y H:i:s T'), 'Authorization:'.$token, 'Content-Type:application/json', 'Language:TR'));
    if($method=="POST"){
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    $response = curl_exec($ch);
    if($response === FALSE){
        return false;
        die(curl_error($ch));
    }
    curl_close($ch);
    return $responseData = json_decode($response, TRUE);
}

public function hatayakala($data){
  if(($data["httpCode"]!=200) && ($data["httpCode"]!=201) ){
    echo "<hr>Dönüt Kodu: <b>".$data["httpCode"]."</b><br>Açıklama: ".$data["description"]."<br><ul><li>Hata Kodu: <b>".$data["response"]["errorCode"]."</b></li><li>".$data["response"]["errorDescription"]."</li></ul><hr>";
    return false;
  }else{
    return true;
  }
}

  function olustur($array){
    $uri= "/v2/users";
    $cdata= $this->curl($uri,$this->api_auth,"POST",$array);
    if($this->hatayakala($cdata)){
      $ary= array();
      $ary["code"]=201;
      $ary["usertoken"]=$cdata["response"]["userToken"];
      return $ary;
    }
  }

  function bilgi($ktoken){
    $uri= "/v2/users/".$ktoken;
    $cdata= $this->curl($uri,$this->api_auth,"GET");
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["adi"]=$cdata["response"]["name"];
      $ary["soyadi"]=$cdata["response"]["surname"];
      $ary["email"]=$cdata["response"]["email"];
      $ary["telno"]=$cdata["response"]["gsmNumber"];
      $ary["tcno"]=$cdata["response"]["tckn"];
      $ary["dgunu"]=$cdata["response"]["birthdate"];
      $ary["durum"]=$cdata["response"]["status"];
      return $ary;
    }
  }

  function kartlar($ktoken){
    $uri= "/v2/users/".$ktoken."/cards";
    $cdata= $this->curl($uri,$this->api_auth,"GET");
    if($this->hatayakala($cdata)){

      $ary= array();

      for ($i=0; $i < count($cdata["response"]["list"]); $i++) {
        array_push($ary,array("cardtoken"=>$cdata["response"]["list"][$i]["cardToken"],"durum"=>$cdata["response"]["list"][$i]["status"]));
      }
      return $ary;
    }
  }

  function kolustur($ktoken){
    $uri= "/v2/users/".$ktoken."/cards/virtual";
    $cdata= $this->curl($uri,$this->api_auth,"POST",array('virtualCardChannel'=>'I','productCode'=>'IK'));
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["cardtoken"]= $cdata["response"]["cardToken"];
      return $ary;
    }
  }
  function telguncelle($ktoken,$telno){
    $uri= "/v2/users/".$ktoken."/gsmnumber";
    $cdata= $this->curl($uri,$this->api_auth,"PUT",array('gsmNumber'=>$telno));
    if($this->hatayakala($cdata)){
      $ary= array();
      $ary["aciklama"]=$cdata["description"];
      return $ary;
    }
  }
  function onaygonder($ktoken){
    $uri= "/v2/users/".$ktoken."/send/otp";
    $cdata= $this->curl($uri,$this->api_auth,"POST"," ");
    if($this->hatayakala($cdata)){
      $ary= array();
      $ary["token"]=$cdata["response"]["token"];
      return $ary;
    }
  }

  function onayla($ktoken,$onaytoken){
    $uri= "/v2/users/".$ktoken."/verify/otp";
    $cdata= $this->curl($uri,$this->api_auth,"POST",array('token'=>$onaytoken,'otp'=>'1111'));
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["aciklama"]=$cdata["description"];
      return $ary;
    }
  }

}

class kart{
  public $api_auth;

  function __construct($token) {
     $this->api_auth= $token["type"]." ".$token["token"];
  }

  function curl($uri,$token,$method='GET',$data=''){
    $ch = curl_init($GLOBALS['baseurl'].$uri);
    if($method=="GET"){
    curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
    }
    if($method=="PUT"){
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Date:'.gmdate('D, d M Y H:i:s T'), 'Authorization:'.$token, 'Content-Type:application/json', 'Language:TR'));
    if($method=="POST"){
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    $response = curl_exec($ch);
    if($response === FALSE){
        return false;
        die(curl_error($ch));
    }
    curl_close($ch);
    return $responseData = json_decode($response, TRUE);
  }

  public function hatayakala($data){
    if(($data["httpCode"]!=200) && ($data["httpCode"]!=201) ){
      echo "<hr>Dönüt Kodu: <b>".$data["httpCode"]."</b><br>Açıklama: ".$data["description"]."<br><ul><li>Hata Kodu: <b>".$data["response"]["errorCode"]."</b></li><li>".$data["response"]["errorDescription"]."</li></ul><hr>";
      return false;
    }else{
      return true;
    }
  }

  function bilgi($karttoken){
    $uri= "/v2/cards/".$karttoken;
    $cdata= $this->curl($uri,$this->api_auth,"GET");
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["adi"]= $cdata["response"]["name"];
      $ary["soyadi"]= $cdata["response"]["surname"];
      $ary["durumkodu"]= $cdata["response"]["cardStatusCode"];
      $ary["sebepkodu"]= $cdata["response"]["cardReasonCode"];
      $ary["sanalkart"]= $cdata["response"]["isVirtualCard"];
      $ary["pkodu"]= $cdata["response"]["productCode"];
      $ary["kayitli"]= $cdata["response"]["registered"];
      $ary["barkod"]= $cdata["response"]["barcodeNo"];
      $ary["no"]= $cdata["response"]["cardNumber"];
      $ary["skt"]= $cdata["response"]["expDate"];
      $ary["cvv"]= $cdata["response"]["cvv"];
      $ary["anlikbakiye"]= $cdata["response"]["availableLimit"];
      $ary["yuklenebilirbakiye"]= $cdata["response"]["loadableLimit"];
      $ary["aylikyuklenebilirbakiye"]= $cdata["response"]["monthlyLoadableLimit"];
      return $ary;
    }
  }

  function olustur(){
    $uri= "/v2/cards/virtual";
    $cdata= $this->curl($uri,$this->api_auth,"POST",array('productCode'=>'IK'));
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["barkod"]=$cdata["response"]["barcodeNumber"];
      $ary["no"]=$cdata["response"]["cardNumber"];
      $ary["skt"]=$cdata["response"]["expDate"];
      $ary["cvv"]=$cdata["response"]["cvv"];

      return $ary;
    }
  }

  function durum($karttoken,$ktoken,$durum){
    $uri= "/v2/cards/".$karttoken."/status";
    $cdata= $this->curl($uri,$this->api_auth,"PUT",array('userToken'=>$ktoken,'cardStatus'=>$durum));
    if($this->hatayakala($cdata)){
      $ary= array();
      $ary["aciklama"]= $cdata["description"];
      return $ary;
    }
  }

  function bakiye($karttoken){
    $uri= "/v2/cards/".$karttoken."/balance";
    $cdata= $this->curl($uri,$this->api_auth,"GET");
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["no"]= $cdata["response"]["cardNumber"];
      $ary["anlikbakiye"]= $cdata["response"]["availableLimit"];
      $ary["yuklenebilirbakiye"]= $cdata["response"]["loadableLimit"];
      $ary["aylikyuklenebilirbakiye"]= $cdata["response"]["monthlyLoadableLimit"];
      return $ary;
    }
  }

  function sifreguncelle($karttoken,$istek){
    $uri= "/v2/cards/".$karttoken."/pin";
    $cdata= $this->curl($uri,$this->api_auth,"PUT",array('issuingType'=>$istek));
    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["aciklama"]= $cdata["description"];
      return $ary;
    }
  }
  function hareket($karttoken,$tbas,$tbit){
    $uri= "/v2/cards/".$karttoken."/transactions/".$tbas."/".$tbit;
    $uri= str_replace(' ', '%20', $uri);

    $cdata= $this->curl($uri,$this->api_auth,"GET");
    if($this->hatayakala($cdata)){

      $ary= array();
      for ($i=0; $i < count($cdata["response"]["list"]); $i++) {
        array_push($ary,array(
          "tarih"=>$cdata["response"]["list"][$i]["transactionDate"],
          "alici"=>$cdata["response"]["list"][$i]["merchant"],
          "referansno"=>$cdata["response"]["list"][$i]["referenceNo"],
          "islemturu"=>$cdata["response"]["list"][$i]["transactionType"],
          "miktar"=>$cdata["response"]["list"][$i]["amount"],
          "birim"=>$cdata["response"]["list"][$i]["currency"],
          "alicikategori"=>$cdata["response"]["list"][$i]["merchantCategory"]
        ));
      }
      return $ary;
    }
  }

  function transfer($karttoken,$ary){
    $uri= "/v2/cards/".$karttoken."/transfer";
    $cdata= $this->curl($uri,$this->api_auth,"POST",$ary);

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["transfertoken"]= $cdata["response"]["transferToken"];
      return $ary;
    }
  }

  function transfertamamla($karttoken,$transfertoken){
    $uri= "/v2/cards/".$karttoken."/transfer";
    $cdata= $this->curl($uri,$this->api_auth,"PUT",array('transferToken'=>$transfertoken));

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["aciklama"]=$ary["description"];
      return $ary;
    }
  }
}
class islemler{
  public $api_auth;

  function __construct($token) {
     $this->api_auth= $token["type"]." ".$token["token"];
  }

  function curl($uri,$token,$method='GET',$data=''){
    $ch = curl_init($GLOBALS['baseurl'].$uri);
    if($method=="GET"){
    curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
    }
    if($method=="PUT"){
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Date:'.gmdate('D, d M Y H:i:s T'), 'Authorization:'.$token, 'Content-Type:application/json', 'Language:TR'));
    if($method=="POST"){
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    $response = curl_exec($ch);
    if($response === FALSE){
        return false;
        die(curl_error($ch));
    }
    curl_close($ch);
    return $responseData = json_decode($response, TRUE);
  }

  public function hatayakala($data){
    if(($data["httpCode"]!=200) && ($data["httpCode"]!=201) ){
      echo "<hr>Dönüt Kodu: <b>".$data["httpCode"]."</b><br>Açıklama: ".$data["description"]."<br><ul><li>Hata Kodu: <b>".$data["response"]["errorCode"]."</b></li><li>".$data["response"]["errorDescription"]."</li></ul><hr>";
      return false;
    }else{
      return true;
    }
  }

  function ekle($barkod,$miktar){
    $uri= "/v2/transactions/in";
    $cdata= $this->curl($uri,$this->api_auth,"POST", array('cashOfficeId'=>1401,'barcodeNumber'=>$barkod,'transactionId'=>rand(0,9999999999),'amount'=>$miktar));

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["transferid"]= $cdata["response"]["transactionId"];
      $ary["barkod"]= $cdata["response"]["barcodeNumber"];
      $ary["miktar"]= $cdata["response"]["amount"];
      return $ary;
    }
  }
  function ekleiptal($barkod,$tid,$miktar){
    $uri= "/v2/transactions/in/cancel";
    $cdata= $this->curl($uri,$this->api_auth,"POST", array('cashOfficeId'=>1401,'barcodeNumber'=>$barkod,'transactionId'=>$tid,'amount'=>$miktar));

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["aciklama"]=$cdata["description"];
      return $ary;
    }
  }
  function tahsilat($karttoken,$miktar,$aciklama){
    $uri= "/v2/transactions/out";
    $cdata= $this->curl($uri,$this->api_auth,"POST", array('cardToken'=>$karttoken,'amount'=>$miktar,'description'=>$aciklama));

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["provisionkodu"]= $cdata["response"]["provisionCode"];
      return $ary;
    }
  }

  function tahsilattamamla($provkodu){
    $uri= "/v2/transactions/".$provkodu."/out";
    $cdata= $this->curl($uri,$this->api_auth,"PUT", array('otp'=>'111111'));

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["referansno"]= $cdata["response"]["referenceNumber"];

      return $ary;
    }
  }
  function tahsilatiptal($karttoken,$refno){
    $uri= "/v2/transactions/out/cancel";
    $cdata= $this->curl($uri,$this->api_auth,"POST",array('cardToken'=>$karttoken,'referenceNumber'=>$refno));

    if($this->hatayakala($cdata)){

      $ary= array();
      $ary["aciklama"]=$cdata["response"]["description"];

      return $ary;
    }
  }

  function noktalar($x,$y){
    $uri= "/v2/transactions/locations/".$x."/".$y;
    $cdata= $this->curl($uri,$this->api_auth,"GET");

    if($this->hatayakala($cdata)){

      $ary= array();

      for ($i=0; $i < count($cdata["response"]["list"]); $i++) {
        array_push($ary,array(
          "X"=>$cdata["response"]["list"][$i]["coordinateX"],
          "Y"=>$cdata["response"]["list"][$i]["coordinateY"],
          "tip"=>$cdata["response"]["list"][$i]["type"],
          "adi"=>$cdata["response"]["list"][$i]["name"],
          "aciklama"=>$cdata["response"]["list"][$i]["description"],
          "adres"=>$cdata["response"]["list"][$i]["address"],
          "icon"=>$cdata["response"]["list"][$i]["icon"]
        ));
      }

      return $ary;
    }
  }
}
