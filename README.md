# İninal Api V 2.0
---
- [Kurulum](#kurulum)
- [Bilgilendirme](#bilgilendirme)
- [Ornek](#ornek)
---
### Kurulum
```php
    require_once("class.php"); //Class Ekleme

    use \eperen\giris; //Giriş İşlemlerini Kullanmak için
    use \eperen\kullanici; //Kullancı İşlemlerini Kullanmak için 
    use \eperen\kart; //Kart İşlemlerini Kullanmak için 
    use \eperen\islemler; //transactions İşlemlerini Kullanmak için
```

### Bilgilendirme
Class 5.X sürümlerinde test edilmiştir.

### Ornek
```php
// Kurulum
    require_once("class.php");
    use \eperen\giris;
    use \eperen\kullanici;
    use \eperen\kart;
    use \eperen\islemler;
// Giriş
    $ininal= new giris("API_KEY","API_SECRET");
    $login= $ininal->giris();
    
## Kullanıcı İşlemleri ##
    $kullanici= new kullanici($login); //kullanici değişkeni altındaki fonksiyonlar kullanılır.
    
## Kart İşlemleri ##
    $kart= new kart($login); //kart değişkeni altındaki fonksiyonlar kullanılır.
    
## İşlemler ##
    $islem= new islemler($login); //islem değişkeni altındaki fonksiyonlar kullanılır.
```

Geliştirci: &copy; ErenKrt