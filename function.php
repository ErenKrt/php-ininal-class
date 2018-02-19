<?php

//    ________                          ___  ____           _    
//   |_   __  |                        |_  ||_  _|         / |_  
//   | |_ \_| _ .--.  .---.  _ .--.    | |_/ /    _ .--.`| |-' 
//   |  _| _ [ `/'`\]/ /__\\[ `.-. |   |  __'.   [ `/'`\]| |   
//  _| |__/ | | |    | \__., | | | |  _| |  \ \_  | |    | |,  
// |________|[___]    '.__.'[___||__]|____||____|[___]   \__/

class epininal{

  public $baseurl="https://sandbox-api.ininal.com";

  public function curl($url,$token,$data='',$method='GET'){

      $gun  = gmdate('D, d M Y H:i:s T');
      $type  ='application/json';
      $dil  ='TR';

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_POST, TRUE);
      if($method=="GET"){
      curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Date:'.$gun, 'Authorization:'.$token, 'Content-Type:'.$type, 'Language:'.$dil));

      if($data!=""){
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

  function sifreolustur() {
      $semboller = '';
      $semboller.='abcdefghijklmnopqrstuvwxyz';
      $semboller.='1234567890';
      $sembol_length = strlen($semboller) - 1;
          $sifre = '';
          for ($i = 0; $i < 8; $i++) {
              $n = rand(0, $sembol_length);
              $sifre .= $semboller[$n];
          }
      return $sifre;
  }

  function giris($auth){
    $baseurl= $this->baseurl;
    $eurl= "/v2/oauth/accesstoken";
    $data= $this->curl($baseurl.$eurl,"Basic ".$auth,"POST");
    if($data["response"]["accessToken"]!=""){
      return $data["response"]["accessToken"];
    }else{
      return false;
    }
  }

  function kartolustur($token){
    $baseurl= $this->baseurl;
    $eurl= "/v2/cards/virtual";

    $data= array("productCode"=>"IK");
    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,"","POST");


    if($data["response"]!=""){
    return $data["response"];
    }else{
      return false;
    }
  }

  function kullaniciolustur($token,$data){
    $baseurl= $this->baseurl;
    $eurl= "/v2/users";


    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,$data,"POST");
    if($data["response"]["userToken"]!=""){
    return $data["response"]["userToken"];
    }else{
      return false;
    }
  }

  function kullanicionaykodu($token,$usertoken){
    $baseurl= $this->baseurl;
    $eurl= "/v2/users/".$usertoken."/send/otp";

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,"","POST");

    if($data["response"]["token"]!=""){
    return $data["response"]["token"];
    }else{
      return false;
    }
  }

  function kullanicionayla($token,$usertoken,$data){
    $baseurl= $this->baseurl;
    $eurl= "/v2/users/".$usertoken."/verify/otp";

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,$data,"POST");

    if($data["httpCode"]=="200"){
    return $data;
    }else{
      return false;
    }
  }

  function kullanicibilgiler($token,$usertoken){
    $baseurl= $this->baseurl;
    $eurl= "/v2/users/".$usertoken;

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,"","GET");

    if($data["response"]!=""){
    return $data["response"];
    }else{
      return false;
    }

  }

  function kullanicikartbilgiler($token,$usertoken){
    $baseurl= $this->baseurl;
    $eurl= "/v2/users/".$usertoken."/cards";

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,"","GET");

    if($data["response"]!=""){
    return $data["response"]["list"];
    }else{
      return false;
    }

  }

  function kullanicikartolustur($token,$usertoken,$data){
    $baseurl= $this->baseurl;
    $eurl= "/v2/users/".$usertoken."/cards/virtual";

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,$data,"POST");

    if($data["response"]!=""){
    return $data["response"];
    }else{
      return false;
    }

  }

  function hareketkontrol($token,$kart,$tarih){
    $baseurl= $this->baseurl;
    $eurl ='/v2/cards/'.$kart.'/transactions/'.$tarih;
    $eurl = str_replace(' ', '%20', $eurl);

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,"","GET");

    if($data["httpCode"]=="200"){
    return $data["response"];
    }else{
      return false;
    }
  }

  function kartbakiye($token,$kart){
    $baseurl= $this->baseurl;
    $eurl ='/v2/cards/'.$kart.'/balance';

    $data= $this->curl($baseurl.$eurl,"Bearer ".$token,"","GET");

    if($data["httpCode"]=="200"){
    return $data["response"];
    }else{
      return false;
    }
  }

}
