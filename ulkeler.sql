-- Veritabanı oluşturma
CREATE DATABASE db_ulkeler CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Veritabanını kullanma
USE db_ulkeler;

-- Ülkeler tablosu
CREATE TABLE ulkeler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(50) NOT NULL,
    resim VARCHAR(255) NOT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Projeler tablosu
CREATE TABLE projeler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ulke_id INT NOT NULL,
    baslik VARCHAR(100) NOT NULL,
    aciklama TEXT NOT NULL,
    resim VARCHAR(255) NOT NULL,
    FOREIGN KEY (ulke_id) REFERENCES ulkeler(id) ON DELETE CASCADE
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Örnek veriler ekleme
INSERT INTO ulkeler (isim, resim) VALUES 
('Türkiye', 'kkt3.png'),
('Amerika Birleşik Devletleri', 'amerika.png'),
('Almanya', 'almanya.png');

INSERT INTO projeler (ulke_id, baslik, aciklama, resim) VALUES 
(1, 'İstanbul Projesi', 'İstanbul\'daki harika bir proje.', 'ist1.jpg'),
(1, 'Ankara Projesi', 'Ankara\'daki özel bir proje.', 'ist1.jpg'),
(2, 'New York Projesi', 'New York\'ta modern bir yapı.', 'italy.jpeg'),
(3, 'Berlin Projesi', 'Berlin\'de eşsiz bir proje.', 'japan.jpg');
