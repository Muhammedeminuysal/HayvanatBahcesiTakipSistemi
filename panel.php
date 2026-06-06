<?php
include 'baglan.php';

if(!isset($_SESSION['kullanici'])) {
    header("Location: index.php");
    exit;
}

$aktif_kullanici = $_SESSION['kullanici'];
$guncellenecek_hayvan = null;
$profil_mesaj = "";

// KİŞİSEL BİLGİLERİ GÜNCELLEME
if (isset($_POST['profil_guncelle'])) {
    $yeni_kadi = trim($_POST['yeni_kullanici_adi']);
    $yeni_sifre = trim($_POST['yeni_sifre']);

    if (!empty($yeni_kadi)) {
        try {
            if (!empty($yeni_sifre)) {
                $hashli_sifre = password_hash($yeni_sifre, PASSWORD_BCRYPT);
                $gursorgu = $baglanti->prepare("UPDATE Kullanicilar SET KullaniciAdi = ?, Sifre = ? WHERE KullaniciAdi = ?");
                $gursorgu->execute([$yeni_kadi, $hashli_sifre, $aktif_kullanici]);
            } else {
                $gursorgu = $baglanti->prepare("UPDATE Kullanicilar SET KullaniciAdi = ? WHERE KullaniciAdi = ?");
                $gursorgu->execute([$yeni_kadi, $aktif_kullanici]);
            }

            $hayvangur = $baglanti->prepare("UPDATE Hayvanlar SET EkleyenKullanici = ? WHERE EkleyenKullanici = ?");
            $hayvangur->execute([$yeni_kadi, $aktif_kullanici]);

            $_SESSION['kullanici'] = $yeni_kadi;
            header("Location: panel.php?basarili=1");
            exit;

        } catch (PDOException $e) {
            $profil_mesaj = "<div class='alert alert-danger'>Bu kullanıcı adı zaten kullanılıyor!</div>";
        }
    }
}

if (isset($_GET['basarili'])) {
    $profil_mesaj = "<div class='alert alert-success'>Profil bilgileriniz başarıyla güncellendi!</div>";
}

// 1. HAYVAN EKLEME (CREATE)
if (isset($_POST['hayvan_ekle'])) {
    $adi = $_POST['hayvan_adi'];
    $turu = $_POST['turu'];
    $saglik = $_POST['saglik'];
    $beslenme = $_POST['beslenme'];
    $alan = $_POST['yasam_alani'];

    $ekle = $baglanti->prepare("INSERT INTO Hayvanlar (HayvanAdi, Turu, SaglikDurumu, BeslenmeAliskanligi, YasamAlani, EkleyenKullanici) VALUES (?, ?, ?, ?, ?, ?)");
    $ekle->execute([$adi, $turu, $saglik, $beslenme, $alan, $aktif_kullanici]);
    header("Location: panel.php");
    exit;
}

// 2. HAYVAN SİLME (DELETE)
if (isset($_GET['sil'])) {
    $sil_id = $_GET['sil'];
    $sil = $baglanti->prepare("DELETE FROM Hayvanlar WHERE id = ? AND EkleyenKullanici = ?");
    $sil->execute([$sil_id, $aktif_kullanici]);
    header("Location: panel.php");
    exit;
}

// 3. HAYVAN DÜZENLEME MODU
if (isset($_GET['duzenle'])) {
    $duzenle_id = $_GET['duzenle'];
    $getir = $baglanti->prepare("SELECT * FROM Hayvanlar WHERE id = ? AND EkleyenKullanici = ?");
    $getir->execute([$duzenle_id, $aktif_kullanici]);
    $guncellenecek_hayvan = $getir->fetch(PDO::FETCH_ASSOC);
}

// 4. HAYVAN GÜNCELLEME (UPDATE)
if (isset($_POST['hayvan_guncelle'])) {
    $hid = $_POST['hayvan_id'];
    $adi = $_POST['hayvan_adi'];
    $turu = $_POST['turu'];
    $saglik = $_POST['saglik'];
    $beslenme = $_POST['beslenme'];
    $alan = $_POST['yasam_alani'];

    $guncelle = $baglanti->prepare("UPDATE Hayvanlar SET HayvanAdi = ?, Turu = ?, SaglikDurumu = ?, BeslenmeAliskanligi = ?, YasamAlani = ? WHERE id = ? AND EkleyenKullanici = ?");
    $guncelle->execute([$adi, $turu, $saglik, $beslenme, $alan, $hid, $aktif_kullanici]);
    header("Location: panel.php");
    exit;
}

// 5. HAYVANLARI LİSTELEME (READ)
$listele = $baglanti->prepare("SELECT * FROM Hayvanlar WHERE EkleyenKullanici = ?");
$listele->execute([$aktif_kullanici]);
$hayvanlar = $listele->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">Hoş geldin, <strong><?php echo htmlspecialchars($aktif_kullanici); ?></strong>!</span>
    <a href="cikis.php" class="btn btn-outline-danger">Oturumu Kapat</a>
</nav>

<div class="container mt-4">
    <?php echo $profil_mesaj; ?>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 mb-4">
                <?php if ($guncellenecek_hayvan): ?>
                    <h5>Hayvan Bilgisi Güncelle</h5>
                    <form action="" method="POST">
                        <input type="hidden" name="hayvan_id" value="<?php echo $guncellenecek_hayvan['id']; ?>">
                        <div class="mb-2"><input type="text" name="hayvan_adi" class="form-control" value="<?php echo htmlspecialchars($guncellenecek_hayvan['HayvanAdi']); ?>" required></div>
                        <div class="mb-2"><input type="text" name="turu" class="form-control" value="<?php echo htmlspecialchars($guncellenecek_hayvan['Turu']); ?>" required></div>
                        <div class="mb-2"><input type="text" name="saglik" class="form-control" value="<?php echo htmlspecialchars($guncellenecek_hayvan['SaglikDurumu']); ?>"></div>
                        <div class="mb-2"><input type="text" name="beslenme" class="form-control" value="<?php echo htmlspecialchars($guncellenecek_hayvan['BeslenmeAliskanligi']); ?>"></div>
                        <div class="mb-2"><input type="text" name="yasam_alani" class="form-control" value="<?php echo htmlspecialchars($guncellenecek_hayvan['YasamAlani']); ?>"></div>
                        <button type="submit" name="hayvan_guncelle" class="btn btn-warning w-100">Değişiklikleri Kaydet</button>
                        <a href="panel.php" class="btn btn-secondary w-100 mt-1">İptal Et</a>
                    </form>
                <?php else: ?>
                    <h5>Yeni Hayvan Ekle</h5>
                    <form action="" method="POST">
                        <div class="mb-2"><input type="text" name="hayvan_adi" class="form-control" placeholder="Hayvan Adı" required></div>
                        <div class="mb-2"><input type="text" name="turu" class="form-control" placeholder="Türü (Örn: Aslan)" required></div>
                        <div class="mb-2"><input type="text" name="saglik" class="form-control" placeholder="Sağlık Durumu"></div>
                        <div class="mb-2"><input type="text" name="beslenme" class="form-control" placeholder="Beslenme Alışkanlığı"></div>
                        <div class="mb-2"><input type="text" name="yasam_alani" class="form-control" placeholder="Yaşam Alanı"></div>
                        <button type="submit" name="hayvan_ekle" class="btn btn-success w-100">Listeme Ekle</button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="card p-3 mb-4 bg-white border-primary">
                <h5 class="text-primary">Kişisel Bilgilerimi Güncelle</h5>
                <form action="" method="POST">
                    <div class="mb-2">
                        <label class="form-label small m-0">Kullanıcı Adı:</label>
                        <input type="text" name="yeni_kullanici_adi" class="form-control" value="<?php echo htmlspecialchars($aktif_kullanici); ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small m-0">Yeni Şifre:</label>
                        <input type="password" name="yeni_sifre" class="form-control" placeholder="Değişmeyecekse boş bırakın">
                    </div>
                    <button type="submit" name="profil_guncelle" class="btn btn-primary btn-sm w-100">Profilimi Güncelle</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3">
                <h5>Hayvanat Bahçenizin Envanteri</h5>
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Hayvan Adı</th>
                            <th>Türü</th>
                            <th>Sağlık</th>
                            <th>Beslenme</th>
                            <th>Yaşam Alanı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($hayvanlar) > 0): ?>
                            <?php foreach($hayvanlar as $hayvan): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($hayvan['HayvanAdi']); ?></td>
                                    <td><?php echo htmlspecialchars($hayvan['Turu']); ?></td>
                                    <td><?php echo htmlspecialchars($hayvan['SaglikDurumu']); ?></td>
                                    <td><?php echo htmlspecialchars($hayvan['BeslenmeAliskanligi']); ?></td>
                                    <td><?php echo htmlspecialchars($hayvan['YasamAlani']); ?></td>
                                    <td>
                                        <a href="panel.php?duzenle=<?php echo $hayvan['id']; ?>" class="btn btn-sm btn-info">Düzenle</a>
                                        <a href="panel.php?sil=<?php echo $hayvan['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?')">Sil</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted">Henüz hiç hayvan eklemediniz.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>