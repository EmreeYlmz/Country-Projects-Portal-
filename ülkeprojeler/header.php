<?php
include("config.php");

// Veritabanından ülke bilgilerini çek
$query = $pdo->prepare("SELECT * FROM ulkeler");
$query->execute();
$ulkeler = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ÜLKELER</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Stil Dosyaları -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /* Sol Navbar */
        .sidepanel {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1050;
            top: 0;
            left: 0;
            background-color: #0f132d;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 60px;
        }

        .sidepanel a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidepanel a:hover {
            background-color: #fff;
        }

        /* İçerik ve Üst Navbar */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1100;
            background: #0f132d;
            padding: 10px 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: margin-left 0.3s ease; /* Geçiş animasyonu */
        }

        #content {
            margin-left: 0;
            transition: margin-left 0.3s ease; /* Geçiş animasyonu */
            padding-top: 70px; /* Üst navbar ile içerik çakışmasın */
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #0f132d;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-right: 15px;
        }

        .openbtn:hover {
            background-color: #0f132d;
        }
    </style>
</head>

<body>
    <!-- Side Navbar -->
    <div id="mySidepanel" class="sidepanel">

        <a href="index.php">AnaSayfa</a>
        <a href="projeler_listesi.php">Tüm Projeler</a>
        <a href="index.php#ulkeler">Ülkeler</a>
        <?php foreach ($ulkeler as $ulke): ?>
            <a href="projeler.php?ulke_id=<?php echo $ulke['id']; ?>">
                <?php echo htmlspecialchars($ulke['isim']); ?>
            </a>
        <?php endforeach; ?>
    </div>

   <!-- Üst Navbar -->
<header>
    <div class="d-flex align-items-center" style="display: flex; justify-content: flex-start; width: 100%;">
        <!-- Menü Açma Butonu -->
        <button class="openbtn" onclick="toggleNav()">☰</button> <!-- Burada toggleNav() fonksiyonu çağırılacak -->
        
        <!-- Logo -->
       <!-- Logo -->
<div class="ms-6" style="margin-left: 50px;"> <!-- Logoyu 1-2 cm sağa kaydırdık -->
    <a href="index.php">
        <img src="images/logo.png" alt="Logo" style="height: 40px;">
    </a>
</div>


        <!-- Sağ Menü -->
        <div class="ms-auto">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">AnaSayfa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="projeler_listesi.php">Tüm Projeler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#ulkeler">Ülkeler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fa fa-globe" aria-hidden="true" title="Dil Desteği"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>


    <!-- JavaScript -->
    <script>
        // Sol navbar açma/kapama işlevi
        function toggleNav() {
            const sidepanel = document.getElementById("mySidepanel");
            const content = document.getElementById("content");

            if (sidepanel.style.width === "250px") {
                sidepanel.style.width = "0"; // Sol navbar kapanacak
                content.style.marginLeft = "0"; // İçerik eski haline dönecek
            } else {
                sidepanel.style.width = "250px"; // Sol navbar açılacak
                content.style.marginLeft = "250px"; // İçerik sağa kayacak
            }
        }
    </script>
</body>
</html>
