<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "hayvanat_bahcesi"; 

try {
    // Değişken adını $db yerine $baglanti yapıyoruz ki sayfalarla çakışmasın
    $baglanti = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veri tabanı bağlantısı başarısız: " . $e->getMessage());
}
?>