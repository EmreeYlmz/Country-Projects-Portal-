<?php
$host = 'localhost'; // Sunucu adresi
$dbname = 'Db_ulkeler'; // Veritabanı adı
$username = 'root'; // Varsayılan kullanıcı adı
$password = ''; // Varsayılan şifre (boş)

// PDO bağlantısı oluşturma
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
