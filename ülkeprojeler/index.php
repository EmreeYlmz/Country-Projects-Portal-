<?php
include("config.php");
include("header.php");

// Veritabanından ülke bilgilerini çek
$query = $pdo->prepare("SELECT * FROM ulkeler");
$query->execute();
$ulkeler = $query->fetchAll(PDO::FETCH_ASSOC);

// Projeleri veritabanından çek
$query = $pdo->prepare("SELECT * FROM projeler");
$query->execute();
$projeler = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="content">
    <!-- Carousel (Kaydırıcı) -->
    <div id="cardCarousel" class="carousel-container mt-5">
        <button class="carousel-btn prev-btn">❮</button>
        <div class="carousel-track">
            <?php foreach ($ulkeler as $ulke): ?>
                <div class="carousel-card" onclick="window.location.href='projeler.php?ulke_id=<?php echo $ulke['id']; ?>'">
                    <img src="images/<?php echo htmlspecialchars($ulke['resim']); ?>" alt="<?php echo htmlspecialchars($ulke['isim']); ?>">
                    <h5><?php echo htmlspecialchars($ulke['isim']); ?></h5>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-btn next-btn">❯</button>
    </div>

    <!-- Ülke Kartları Bölümü -->
    <div id="ulkeler" class="container mt-5">
        <h3 class="text-center">Ülkeler</h3>
        <div class="row">
            <?php foreach ($ulkeler as $ulke): ?>
                <div class="col-md-4">
                    <div class="card" onclick="openModal(<?php echo $ulke['id']; ?>)">
                        <img src="images/<?php echo htmlspecialchars($ulke['resim']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($ulke['isim']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($ulke['isim']); ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Modal (Projeler) -->
<div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryModalLabel">Ülke Projeleri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="projectCards" class="row">
                    <!-- Projeler buraya dinamik olarak yüklenecek -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Projeleri PHP'den al
    const projects = <?php echo json_encode($projeler); ?>;

    // Kartlara tıklanınca modal açılır
    function openModal(ulkeId) {
        const projectCards = document.getElementById("projectCards");
        projectCards.innerHTML = ""; // Modal içeriğini temizle

        // Seçilen ülkenin projelerini filtrele
        const filteredProjects = projects.filter(proje => proje.ulke_id == ulkeId);

        // Her proje için kart oluştur
        filteredProjects.forEach(proje => {
            const card = `
                <div class="col-md-4">
                    <div class="card" onclick="window.location.href='proje.php?id=${proje.id}'">
                        <img src="images/${proje.resim}" class="card-img-top" alt="${proje.baslik}">
                        <div class="card-body">
                            <h5 class="card-title">${proje.baslik}</h5>
                            <p class="card-text">${proje.aciklama}</p>
                        </div>
                    </div>
                </div>
            `;
            projectCards.innerHTML += card;
        });

        // Modal'ı göster
        const modal = new bootstrap.Modal(document.getElementById('countryModal'));
        modal.show();
    }
    document.addEventListener('DOMContentLoaded', () => {
        const track = document.querySelector('.carousel-track');
        let cards = Array.from(document.querySelectorAll('.carousel-card'));
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');

        const cardWidth = cards[0].offsetWidth + 10; // Kart genişliği + gap (10px)
        let currentIndex = cards.length; // Orta konum (baş ve son kopyalar eklendiğinde)
        let isMoving = false; // Hareket kontrolü

        // Baş ve son kopyaları yükle
        const initializeCarousel = () => {
            const firstSet = cards.map(card => card.cloneNode(true));
            const lastSet = cards.map(card => card.cloneNode(true));

            firstSet.forEach(card => {
                track.appendChild(card);
                card.addEventListener('click', handleCardClick);
            });

            lastSet.reverse().forEach(card => {
                track.insertBefore(card, track.firstChild);
                card.addEventListener('click', handleCardClick);
            });

            track.style.transform = `translateX(${-cardWidth * currentIndex}px)`; // Orta konuma başla
        };

        // Kart tıklama işlevi
        const handleCardClick = (event) => {
            const card = event.currentTarget;
            const targetUrl = card.getAttribute('data-url');
            if (targetUrl) {
                window.location.href = targetUrl;
            }
        };

        // İlk kartlara tıklama olayını bağla
        cards.forEach(card => {
            card.addEventListener('click', handleCardClick);
        });

        initializeCarousel();

        // Geçiş fonksiyonu
        const moveCarousel = (direction) => {
            if (isMoving) return; // Hareket sırasında tekrar tıklamayı engelle
            isMoving = true;

            if (direction === 'next') {
                currentIndex++;
            } else if (direction === 'prev') {
                currentIndex--;
            }

            // Geçişi uygula
            track.style.transition = 'transform 0.3s ease-in-out';
            track.style.transform = `translateX(${-cardWidth * currentIndex}px)`;

            // Geçiş sonrasında kontrol et
            track.addEventListener('transitionend', () => {
                if (currentIndex >= track.children.length - cards.length) {
                    track.style.transition = 'none';
                    currentIndex -= cards.length; // Pozisyonu sıfırla
                    track.style.transform = `translateX(${-cardWidth * currentIndex}px)`;
                }

                if (currentIndex < cards.length) {
                    track.style.transition = 'none';
                    currentIndex += cards.length; // Pozisyonu sıfırla
                    track.style.transform = `translateX(${-cardWidth * currentIndex}px)`;
                }

                isMoving = false; // Hareket tamamlandıktan sonra kilidi aç
            }, { once: true });
        };

        // Kullanıcı hareketi
        nextBtn.addEventListener('click', () => moveCarousel('next'));
        prevBtn.addEventListener('click', () => moveCarousel('prev'));
    });
</script>
