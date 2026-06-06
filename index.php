<?php
include 'baglan.php';

if(isset($_SESSION['kullanici'])) {
    header("Location: panel.php");
    exit;
}

$mesaj = "";
$hata = "";

// ÜYE OLMA (KAYIT) İŞLEMİ
if (isset($_POST['kayit_ol'])) {
    $kadi = trim($_POST['kullanici_adi']);
    $sifre = trim($_POST['sifre']); 

    if(!empty($kadi) && !empty($sifre)) {
        $hashli_sifre = password_hash($sifre, PASSWORD_BCRYPT);
        
        try {
            $ekle = $baglanti->prepare("INSERT INTO kullanicilar (KullaniciAdi, Sifre) VALUES (?, ?)");
            $ekle->execute([$kadi, $hashli_sifre]);
            $mesaj = "Tebrikler, başarıyla üye oldunuz! Şimdi giriş yapabilirsiniz.";
        } catch (PDOException $e) {
            $hata = "Bu kullanıcı adı sistemde zaten kayıtlı!";
        }
    } else {
        $hata = "Lütfen tüm alanları doldurun!";
    }
}

// GİRİŞ YAPMA İŞLEMİ
if (isset($_POST['giris_yap'])) {
    $kadi = trim($_POST['kullanici_adi']);
    $sifre = trim($_POST['sifre']); 

    if(!empty($kadi) && !empty($sifre)) {
        $sorgu = $baglanti->prepare("SELECT * FROM kullanicilar WHERE KullaniciAdi = ?");
        $sorgu->execute([$kadi]);
        $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

        if ($kullanici && password_verify($sifre, $kullanici['Sifre'])) {
            $_SESSION['kullanici'] = $kullanici['KullaniciAdi'];
            header("Location: panel.php");
            exit;
        } else {
            $hata = "Kullanıcı adı veya şifre hatalı!";
        }
    } else {
        $hata = "Lütfen tüm alanları doldurun!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hayvan Takip Sistemi - Üye Ol / Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h3 class="text-center mb-4">Hayvan Takip Sistemi</h3>
                
                <?php if($mesaj): ?> <div class="alert alert-success"><?php echo $mesaj; ?></div> <?php endif; ?>
                <?php if($hata): ?> <div class="alert alert-danger"><?php echo $hata; ?></div> <?php endif; ?>

                <form action="" method="POST" class="mb-4">
                    <h5>Giriş Yap</h5>
                    <div class="mb-3">
                        <input type="text" name="kullanici_adi" class="form-control" placeholder="Kullanıcı Adınız" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="sifre" class="form-control" placeholder="Şifreniz" required>
                    </div>
                    <button type="submit" name="giris_yap" class="btn btn-success w-100">Giriş Yap</button>
                </form>
                <hr>
                <form action="" method="POST">
                    <h5>Hesabınız Yok mu? Üye Olun</h5>
                    <div class="mb-3">
                        <input type="text" name="kullanici_adi" class="form-control" placeholder="Kullanıcı Adı Belirleyin" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="sifre" class="form-control" placeholder="Şifre Belirleyin" required>
                    </div>
                    <button type="submit" name="kayit_ol" class="btn btn-primary w-100">Üye Ol</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>