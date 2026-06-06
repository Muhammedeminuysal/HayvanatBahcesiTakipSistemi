# 🦁 ZooTrack: HAYVANAT BAHÇESİ HAYVAN TAKİP SİSTEMİ

## 📋 Proje Genel Bakış

Doğaya ve vahşi yaşama olan ilgimden dolayı, bir hayvanat bahçesindeki operasyonel süreçlerin dijital ortamda nasıl yönetilebileceğini simüle etmek adına bu projeyi geliştirdim. Bu proje, bir hayvanat bahçesindeki hayvanların sağlık durumlarını, beslenme alışkanlıklarını, yaşam alanlarını ve diğer kritik verilerini izlemek, kaydetmek ve analiz etmek için tasarlanmış kapsamlı bir dijital yönetim çözümüdür.

Sistem; bakıcıların, veterinerlerin ve klinik personelin manuel not tutma ve kağıt belge yönetimi ihtiyaçlarını ortadan kaldırarak tüm verileri tek bir noktada toplar. Hayvanların envanter durumları görsel olarak okunması kolay kartlar halinde listelenir. Proje, özellikle veri güvenliğini ön planda tutan mimarisi ve her kullanıcının sadece kendi hayvanat bahçesini yönetebileceği izole yapısıyla otantik ve kullanışlı bir default iskelet sunmaktadır.

## 🌟 Sistem İçinde Sunulan Faydalar

### 📊 Hayvan Verilerinin Merkezi Yönetimi

Hayvanat Bahçesi Hayvan Takip Sistemi, tüm envanter ve takipleri tek bir güvenli platformda birleştirir:

- **Kimlik Bilgileri**: Hayvanların isimlerini ve türlerini kolayca kaydedin ve erişin.
- **Sağlık/Klinik Durum**: Hayvanların güncel sağlık durumlarını (İyi, Tedavide, Karantinada vb.) anlık takip edin.
- **Beslenme Alışkanlıkları**: Türlerin etçil/otçul eğilimlerini ve günlük porsiyon/yem planlamalarını belgeleyin.
- **Yaşam Alanları (Barınaklar)**: Hayvanların hangi kafes veya sirkülasyon alanlarında (Savan Bölgesi, Kutup Evi vb.) barındığını izleyin.

### 📈 Operasyonel Verimlilik Artışı

Sistem, aşağıdaki özelliklerle yönetim süreçlerini kolaylaştırır:

- **Zaman Tasarrufu**: Klasik dosyalama ve veri karmaşıklığını tamamen ortadan kaldırır.
- **İzole Havuz Yönetimi**: Güvenli oturum kontrolleri sayesinde her kullanıcı sadece kendi eklediği hayvanları ve alanları yönetir. Ahmet'in eklediği Aslan'ı Mehmet görmez; böylece çoklu veri havuzu kişiselleştirilir.
- **Her Yerden Erişim**: Responsive (mobil uyumlu) yapısı sayesinde bilgisayar, tablet veya akıllı telefonlardan sisteme güvenle erişilebilir.
- **Hızlı Güncelleme**: Hayvanların sağlık veya barınak değişiklikleri anında güncellenerek panelde listelenir.

### 🛡️ Veri Güvenliği ve Gizlilik

- **🔒 Şifreli Veri Saklama**: Kullanıcı şifreleri veri tabanına doğrudan/açık metin olarak yazılmaz. `password_hash()` (BCRYPT) algoritması kullanılarak tamamen hash'lenmiş olarak saklanır.
- **👤 Güvenli Oturum Yönetimi**: Sistemde düz çerezler (cookies) yerine **Oturumlar (Sessions)** kullanılmıştır. Kritik kullanıcı verileri tamamen sunucu tarafında (server-side) kilit altına alınmıştır; tarayıcıda ise sadece rastgele üretilen geçici `PHPSESSID` anahtarı taşınır.

---

## 🎬 ÖRNEK KULLANIM AKIŞI

1. **👨‍⚕️ Giriş ve Hesap Oluşturma**:
   - Kullanıcı, ana ekrandaki "Üye Ol" formunu kullanarak benzersiz bir kullanıcı adı ve şifreyle sistemde kendi güvenli hesabını oluşturur.
   - Oluşturduğu hesapla güvenli bir şekilde giriş (Login) yapar ve sunucu üzerinde session oturumu başlatılır.

2. **➕ Yeni Hayvan Ekleme (Create)**:
   - Yönetim panelindeki formu kullanarak hayvanın adını, türünü, barınağını, beslenme ve sağlık durumunu sisteme kaydeder.
   - Eklenen veri, o an oturumu açık olan kullanıcının ismiyle (`EkleyenKullanici`) veri tabanına işlenir.

3. **🔍 Envanter Listeleme ve İnceleme (Read)**:
   - Kullanıcı, ana panelin sağ tarafında sadece kendi eklemiş olduğu hayvanların dinamik ve temiz bir listesini kart/tablo yapısında görür.

4. **✏️ Bilgileri Düzenleme ve Güncelleme (Update)**:
   - Herhangi bir hayvan kaydındaki "Düzenle" butonuna tıklandığında, ilgili hayvanın mevcut bilgileri form alanlarına otomatik geri yüklenir. Değişiklikler yapılıp kaydedildiğinde veri tabanı güncellenir.
   - Ayrıca "Kişisel Bilgilerimi Güncelle" alanı sayesinde kullanıcı kendi kullanıcı adını veya şifresini değiştirebilir. Kullanıcı adı değiştiğinde, eklediği tüm hayvanlar da otomatik olarak yeni kullanıcı adına transfer edilir.

5. **🗑️ Kayıt Silme (Delete)**:
   - Listeden kaldırılmak istenen bir hayvanın yanındaki "Sil" butonuna tıklandığında, sistem kullanıcıdan onay (`confirm`) ister ve onay verilirse kayıt veri tabanından tamamen temizlenir.

---

## 🛠️ Kullanılan Teknolojiler

- **Backend (Arka Uç):** Yalın PHP (Herhangi bir harici kütüphane veya framework kullanılmadan tamamen ham PHP ile kodlanmıştır)
- **Veri Tabanı:** MySQL / MariaDB (PDO sürücüsü kullanılarak güvenli bağlantı sağlanmıştır)
- **Frontend (Ön Uç):** HTML5, CSS3, Bootstrap 5 (Responsive / Mobil Uyumlu)

---

# 💻 Kurulum Kılavuzu

Bu kılavuz, sistemi yerel bilgisayarınızda (localhost) sorunsuz bir şekilde ayağa kaldırabilmeniz için adım adım talimatlar sunmaktadır.

## 📋 Kurulum Adımları

### 1️⃣ Yerel Sunucu (XAMPP) Kurulumu
1. Eğer bilgisayarınızda kurulu değilse, [XAMPP resmi web sitesinden](https://www.apachefriends.org/index.html) sisteminize uygun sürümü indirin ve kurun.
2. Kurulum bittikten sonra XAMPP Control Panel'i açarak **Apache** ve **MySQL** modüllerinin yanındaki **Start** butonlarına tıklayın. Modüllerin yeşil renge döndüğünden emin olun.

### 2️⃣ Proje Dosyalarının Yerleştirilmesi
1. GitHub repomuzdaki tüm dosyaları ZIP olarak indirin.
2. İndirdiğiniz ZIP dosyasının içindeki dosyaları kopyalayarak XAMPP'in kurulu olduğu dizindeki `htdocs` klasörünün altında **`hayvanatbahcesi`** adında bir klasör açıp içine yapıştırın:
   - Yolun tam olarak şu şekilde olduğundan emin olun: `C:\xampp\htdocs\hayvanatbahcesi\`

### 3️⃣ Veri Tabanının Hazırlanması
1. Tarayıcınızdan `http://localhost/phpmyadmin/` adresine gidin.
2. Sol menüden **Yeni (New)** butonuna tıklayarak `hayvanat_bahcesi` adında bir veri tabanı oluşturun. (Karşılaştırma alanını `utf8_general_ci` veya `utf8mb4_general_ci` seçebilirsiniz).
3. Oluşturduğunuz `hayvanat_bahcesi` veri tabanına tıklayın ve üst menüdeki **SQL** sekmesine gelin.
4. Aşağıdaki SQL kodlarını metin kutusuna yapıştırıp **Git (Go)** butonuna tıklayın:

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
