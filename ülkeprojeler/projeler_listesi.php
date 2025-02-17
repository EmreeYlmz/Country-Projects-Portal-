<?php
include("config.php");  // Veritabanı bağlantısını sağlayacak
include("header.php");  // Header dosyasını dahil et

// Tüm projeleri al
$query = $pdo->prepare("SELECT p.*, u.isim AS ulke_isim FROM projeler p JOIN ulkeler u ON p.ulke_id = u.id");
$query->execute();
$projeler = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Projeler Listesi İçeriği -->
<div id="content">
    <div class="container mt-5">
        <h1 class="text-center">Tüm Projeler</h1>
        <div class="row mt-4">
            <?php foreach ($projeler as $proje): ?>
                <div class="col-md-4 mb-4">
                    <div class="card" style="cursor: pointer;" onclick="window.location.href='proje.php?id=<?php echo $proje['id']; ?>'">
                        <img src="images/<?php echo htmlspecialchars($proje['resim']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($proje['baslik']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($proje['baslik']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($proje['aciklama']); ?></p>
                            <p class="card-text text-muted"><small>Ülke: <?php echo htmlspecialchars($proje['ulke_isim']); ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
