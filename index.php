<?php

//    ________                          ___  ____           _    
//   |_   __  |                        |_  ||_  _|         / |_  
//   | |_ \_| _ .--.  .---.  _ .--.    | |_/ /    _ .--.`| |-' 
//   |  _| _ [ `/'`\]/ /__\\[ `.-. |   |  __'.   [ `/'`\]| |   
//  _| |__/ | | |    | \__., | | | |  _| |  \ \_  | |    | |,  
// |________|[___]    '.__.'[___||__]|____||____|[___]   \__/

require_once("function.php");

$ininal= new epininal();

$api_key="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
$api_secret="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$api_auth= base64_encode($api_key.":".$api_secret);

$giris= $ininal->giris($api_auth);

if($giris){
$token= $giris;

$data=array('name'=>'İsim','surname'=>'Soyİsim','email'=>'email@email.com','gsmNumber'=>'5300000000','tcIdentificationNumber'=>'91111111119'
,'password'=>'123qweasd','birthDate'=>'1982-04-03','motherMaidenName'=>'kızlıksoyadı');



$kullanici= $ininal->kullaniciolustur($token,$data);
print_r($kullanici);
//$kullanicionay= $ininal->kullanicionaykodu($token,$kullanici);

//$data= array('token'=>$kullanicionay,'otp'=>'1111');
//$kullanicionayla= $ininal->kullanicionayla($token,$kullanici,$data);
//$kullanicikontrol= $ininal->kullanicibilgiler($token,$kullanici);
//$data= array('virtualCardChannel'=>'I','productCode'=>'IK');
//$kullanicikartolustur= $ininal->kullanicikartolustur($token,$kullanici,$data);
//$karttoken= $kullanicikartkontrol["cardToken"]
//$kullanicikartkontrol= $ininal->kullanicikartbilgiler($token,$kullanici);
//$kart= $kullanicikartkontrol[0]["cardToken"];


//$kart= $ininal->kartolustur($token);

//$hareketler= $ininal->hareketkontrol($token,$kart,"Fri 21 Jul 2016 12:30:34 GMT/Fri 21 Jul 2017 12:30:34 GMT");
//$bakiye= $ininal->kartbakiye($token,$kart);
//
}else{
  echo "Hata ! Lütfen kodları kontrol ediniz.";
}

exit;
