# 🦁 Hayvanat Bahçesi Hayvan Takip Sistemi

Bu proje, bir hayvanat bahçesindeki hayvanların sağlık durumlarını, beslenme alışkanlıklarını ve yaşam alanlarını izlemek, kaydetmek ve analiz etmek için geliştirilmiş **dinamik ve kişiselleştirilmiş bir Web tabanlı Yönetim Sistemidir**. 

Sistem, düz çerezler (cookies) yerine **güvenli oturum yönetimi (Session)** mimarisine sahip olup, her kullanıcının sadece kendi hayvanat bahçesi envanterini yönetebileceği izole bir yapı sunar.

## 🚀 Özellikler

- **Güvenli Kayıt ve Giriş Sistemi:** Kullanıcılar sisteme üye olabilir. Şifreler veri tabanında açık metin olarak değil, `password_hash()` (BCRYPT) kullanılarak güvenli bir şekilde hashlenmiş olarak saklanır.
- **Tam CRUD Döngüsü:** Kullanıcılar kendi panelleri üzerinden hayvan **Ekleyebilir (Create)**, envanterlerini **Listeyebilir (Read)**, bilgilerini **Güncelleyebilir (Update)** ve kayıtları **Silebilir (Delete)**.
- **Kişiselleştirilmiş Panel:** Güvenli oturum kontrolü (Session) sayesinde Ahmet'in eklediği hayvanı Mehmet görmez; herkes kendi envanterini yönetir.
- **Profil Yönetimi:** Kullanıcılar istedikleri zaman kullanıcı adlarını ve şifrelerini güncelleyebilir. Kullanıcı adı değiştiğinde, ekledikleri hayvanlar otomatik olarak yeni isimlerine aktarılır.
- **Modern Arayüz:** Tasarım puanı kriterlerine tam uyum sağlamak amacıyla **Bootstrap 5** kütüphanesi kullanılarak mobil uyumlu (responsive) ve şık bir arayüz geliştirilmiştir.

## 🛠️ Kullanılan Teknolojiler

- **Backend:** PHP (PDO Veri Tabanı Sürücüsü)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, Bootstrap 5

## 📋 Veri Tabanı Şeması

Proje, ilişkisel kısıtlamaların lokal/canlı ortam geçişlerinde harf duyarlılığı (case sensitivity) sorunları yaratmaması adına optimize edilmiş tamamen küçük harfli tablolardan oluşur:

```sql
CREATE TABLE kullanicilar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    KullaniciAdi VARCHAR(50) NOT NULL UNIQUE,
    Sifre VARCHAR(255) NOT NULL
);

CREATE TABLE hayvanlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    HayvanAdi VARCHAR(50) NOT NULL,
    Turu VARCHAR(50) NOT NULL,
    SaglikDurumu VARCHAR(100),
    BeslenmeAliskanligi VARCHAR(100),
    YasamAlani VARCHAR(50),
    EkleyenKullanici VARCHAR(50) NOT NULL
);
