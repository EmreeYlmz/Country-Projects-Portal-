<?php
include("config.php");
include("header.php"); // Header dosyasını dahil et

// GET parametresiyle proje ID'sini al
$proje_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Proje bilgilerini al
$query = $pdo->prepare("SELECT p.*, u.isim AS ulke_isim FROM projeler p JOIN ulkeler u ON p.ulke_id = u.id WHERE p.id = ?");
$query->execute([$proje_id]);
$proje = $query->fetch(PDO::FETCH_ASSOC);

if (!$proje) {
    die("Proje bulunamadı!");
}
?>

<div id="content">
    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($proje['baslik']); ?></h1>
        <p><strong>Ülke:</strong> <?php echo htmlspecialchars($proje['ulke_isim']); ?></p>
        <p><?php echo htmlspecialchars($proje['aciklama']); ?></p>
        <img src="images/<?php echo htmlspecialchars($proje['resim']); ?>" alt="<?php echo htmlspecialchars($proje['baslik']); ?>" style="max-width: 100%; height: auto;">
    </div>
</div>