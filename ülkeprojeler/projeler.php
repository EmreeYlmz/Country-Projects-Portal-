<?php
include("config.php");
include("header.php"); // Header'ı dahil et

// Gelen ülke ID'sini al
$ulke_id = isset($_GET['ulke_id']) ? (int)$_GET['ulke_id'] : 0;

// Seçilen ülkeye ait projeleri al
$query = $pdo->prepare("SELECT p.*, u.isim AS ulke_isim FROM projeler p JOIN ulkeler u ON p.ulke_id = u.id WHERE u.id = ?");
$query->execute([$ulke_id]);
$projeler = $query->fetchAll(PDO::FETCH_ASSOC);

// Eğer proje yoksa hata mesajı göster
if (!$projeler) {
    die("Bu ülkeye ait proje bulunamadı.");
}

// Ülke bilgisi
$ulke_isim = $projeler[0]['ulke_isim'];
?>

<!-- İçerik -->
<div id="content">
    <div class="container mt-5">
        <h1 class="text-center"><?php echo htmlspecialchars($ulke_isim); ?> - Projeler</h1>
        <div class="row mt-4">
            <?php foreach ($projeler as $proje): ?>
            <div class="col-md-4">
                <div class="card" onclick="window.location.href='proje.php?id=<?php echo $proje['id']; ?>'">
                    <img src="images/<?php echo htmlspecialchars($proje['resim']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($proje['baslik']); ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($proje['baslik']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($proje['aciklama']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
