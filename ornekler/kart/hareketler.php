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

$kullanicikartkontrol= $ininal->kullanicikartbilgiler($token,$kullanicitoken);
$kart= $kullanicikartkontrol[0]["cardToken"];

$hareketler= $ininal->hareketkontrol($token,$kart,"Fri 21 Jul 2016 12:30:34 GMT/Fri 21 Jul 2017 12:30:34 GMT");
// Format:
// {Başlangıç_Tarihi}/{Bitiş_Tarihi}
// Başlangıç tarihi. 'M DD, YYYY HH:MM:SS GMT formatında' yollanmalıdır. (August 28, 2016 16:20:39 GMT)
// Bitiş tarihi. 'M DD, YYYY HH:MM:SS GMT formatında' yollanmalıdır. (August 28, 2017 12:20:20 GMT)
print_r($hareketler);

}else{
  echo "Hata. Lütfen api_key ve secret_keyi kontrol ediniz";
}
?>
