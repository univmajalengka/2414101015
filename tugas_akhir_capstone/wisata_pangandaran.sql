CREATE DATABASE IF NOT EXISTS wisata_pangandaran;
USE wisata_pangandaran;

CREATE TABLE paket_wisata (
    id_paket INT AUTO_INCREMENT PRIMARY KEY,
    nama_paket VARCHAR(100),
    deskripsi TEXT,
    gambar VARCHAR(255),
    link_video VARCHAR(255)
);

INSERT INTO paket_wisata (nama_paket, deskripsi, gambar, link_video) VALUES 
('Green Canyon Body Rafting', 'Jelajahi sungai hijau tosca dengan tebing indah.', 'paket1.jpg', 'https://www.youtube.com/watch?v=Hu123Example'),
('Sunset Pantai Pasir Putih', 'Nikmati sunset terbaik dan lihat Rusa di cagar alam.', 'paket2.jpg', 'https://www.youtube.com/watch?v=AbcExample'),
('Citumang River Tubing', 'Body rafting santai di sungai jernih tengah hutan.', 'paket3.jpg', 'https://www.youtube.com/watch?v=XyzExample'),
('Konservasi Penyu Batu Hiu', 'Wisata edukasi melihat penyu dan pemandangan laut lepas.', 'paket4.jpg', 'https://www.youtube.com/watch?v=DefExample');

CREATE TABLE pemesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    nama_pemesan VARCHAR(100),
    no_hp VARCHAR(20),
    tgl_pesan DATE,
    waktu_pelaksanaan INT,
    jumlah_peserta INT,
    layanan_penginapan BOOLEAN,
    layanan_transport BOOLEAN,
    layanan_makan BOOLEAN,
    harga_paket DECIMAL(15,2),
    total_tagihan DECIMAL(15,2)
);