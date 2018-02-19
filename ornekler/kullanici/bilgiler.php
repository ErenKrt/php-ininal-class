<?php

require_once("../../function.php");

$ininal= new epininal();

$api_key="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
$api_secret="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$api_auth= base64_encode($api_key.":".$api_secret);

$giris= $ininal->giris($api_auth);

if($giris){
$token= $giris;

$data=array('name'=>'İsim','surname'=>'Soyİsim','email'=>'email@email.com','gsmNumber'=>'5300000000','tcIdentificationNumber'=>'91111111119'
,'password'=>'123qweasd','birthDate'=>'1982-04-03','motherMaidenName'=>'kızlıksoyadı');

$kullanicitoken= $ininal->kullaniciolustur($token,$data);
// Ya da
// $kullanicitoken="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$kullanicikontrol= $ininal->kullanicibilgiler($token,$kullanicitoken);

print_r($kullanicikontrol);
}else{
  echo "Hata. Lütfen api_key ve secret_keyi kontrol ediniz";
}
?>
