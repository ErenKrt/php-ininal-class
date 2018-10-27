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
 
error_reporting( E_ALL );

require_once("class.php");
use \eperen\giris;
use \eperen\kullanici;
use \eperen\kart;
use \eperen\islemler;
$ininal= new giris("35425417480402bf8f03977896ba7cc74f30aaa7f34b3be871768dc6c3e5e633","812b47643fedf8058be46747ad3747db2568cd69c426e263b95240ee2af7005e82eebc47c2e38274890fbab123c281da85bf163c589baeb11e7f52a200ef0124");
$login= $ininal->giris();
//Kullanici fonksiyonlarını çağır.
$kullanici= new kullanici($login);

########### Kullanıcı Oluşturma ###########
$data= array('name'=>'Ahm1et23','surname'=>'Oz1person','email'=>'ahm1etd23@ahmet.com','gsmNumber'=>'5130000000','tcIdentificationNumber'=>'00000000000'
,'password'=>'123q1weasd','birthDate'=>'1982-04-03','motherMaidenName'=>'yi1lmaz');
//print_r($kullanici->olustur($data));

########### Kullanıcı Bilgisi Getirme ###########
$ktoken= "f6f9be6d-2de9-405b-a07c-68dc86e33c05"; //Kullanıcı tokeni oluşturma kısmında array olarak verilir. Token kaydedilerek burada çağırılır.
//print_r($kullanici->bilgi($ktoken));

########### Kullanıcı Kart Bilgisi Getirme ###########
$ktoken= "f6f9be6d-2de9-405b-a07c-68dc86e33c05"; //Kullanıcı tokeni oluşturma kısmında array olarak verilir. Token kaydedilerek burada çağırılır.
//print_r($kullanici->kartlar($ktoken));

########### Kullanıcı Kart Oluşturma ###########
$ktoken= "f6f9be6d-2de9-405b-a07c-68dc86e33c05"; //Kullanıcı tokeni oluşturma kısmında array olarak verilir. Token kaydedilerek burada çağırılır.
//print_r($kullanici->kolustur($ktoken));

########### Kullanıcı Telefon Numarası Güncelleme ###########
//print_r($kullanici->telguncelle($ktoken,"5454545454"));

########### Kullanıcı Tek şifrelik onay gönder ###########
//$onay= $kullanici->onaygonder($ktoken);
//$onaytoken=$onay["token"];

########### Kullanıcı Tek şifrelik onayı doğrula ###########
//print_r($kullanici->onayla($ktoken,$onaytoken));

//Kart fonksiyonlarını çağır.
$kart= new kart($login);

########### Kart Bilgisini Getirme ###########
$karttoken= "83406affd8654267a4758fa40c9dd81a";
//print_R($kart->bilgi($karttoken));

########### Anonim Sanal Kart Oluşturma ###########
//print_r($kart->olustur());

########### Kart Durum Güncelleme ###########
//print_r($kart->durum($karttoken,$ktoken,"UNBLOCK"));

########### Kart Bakiye Alma ###########
//print_R($kart->bakiye($karttoken));

########### Kart Şifre Güncelleme ###########
//print_r($kart->sifreguncelle($karttoken,"NEW")); // NEW ya da OLD

########### Kart Hareketlerini Görüntüleme ###########
//print_R($kart->hareket($karttoken,"Fri 21 Jul 2016 12:30:34 GMT","Fri 21 Jul 2017 12:30:34 GMT")); // karttoken, işlem aralığı başlangıç tarihi, işlem aralığı bitiş tarihi

########### Bakiye transferi başlatma ###########
$array= array(
  'targetBarcodeNumber'=>'0000000015293', // Gönderilecek Barkod
  'feeResource'=>'SOURCE', // Transfer üçretinin kesileceği taraf SOURCE: Gönderen Ödemeli | TARGET : Alıcı Ödemeli
  'amount'=>'10', // Miktar
  'description'=>'Kira ücreti'); // Açıklama

//print_r($kart->transfer($karttoken,$array));

########### Bakiye transferi Tamamlama ###########
$transfertoken= "c0bcb84f60564072a059739d22956e2e";
//print_r($kart->transfertamamla($karttoken,$transfertoken));

//İşlemler(transactions) fonksiyonlarını çağır.
$islem= new islemler($login);

########### Bakiye Ekleme ###########
//print_r($islem->ekle("0000000015293","20"));

########### Bakiye Ekleme İptal ###########
$barkod= "0000000015293";
$miktar= "10";
$transferid= "180217099";
//print_r($islem->ekleiptal($barkod,$transferid,$miktar));

########### Tahsilat Başlatma ###########
//print_R($islem->tahsilat($karttoken,$miktar,"Deneme"));

########### Tahsilat Başlatma Tamamlama ###########
$provkodu= "f330c87ce24e47c3b46c7b6aea26eec5";
//print_r($islem->tahsilattamamla($provkodu));

########### Tahsilat İptal ###########
$refno= "c580c2bc59b4407bae2ff03e6caea6f9";
//print_r($islem->tahsilatiptal($karttoken,$refno));

########### Yükleme Noktaları ###########

print_R($islem->noktalar("32.8597","39.9334")); // Ankara
