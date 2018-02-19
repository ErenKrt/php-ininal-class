ininal API için hazırlanmış basit class.

---

- [Kurulum](#kurulum)
- [Bilgilendirme](#bilgilendirme)
- [Örnekler](#örnekler)
- [Contribute](#güncellemeler)

---

### Kurulum

Php üzerinde basit kurulum:

    require_once("function.php");
	require 'function.php';


### Bilgilendirme

Class 5.3, 5.4, 5.5, 5.6 sürümlerinde çalışmaktadır.

### Örnekler

Daha fazla örnek için: [ornekler](https://github.com/ErenKrt/php-ininal-class/ornekler).

```php
require_once("../../function.php");

$ininal= new epininal();

$api_key="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
$api_secret="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

$api_auth= base64_encode($api_key.":".$api_secret);

$giris= $ininal->giris($api_auth);

if($giris){
echo "Giriş başarılı";
}else{
  echo "Hata. Lütfen api_key ve secret_keyi kontrol ediniz";
}
```

### Güncellemeler
- Yeni güncellemede kullanım daha basite ve daha temize dönüştürülecektir.
