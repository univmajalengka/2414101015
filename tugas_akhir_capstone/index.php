<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Wisata Pantai Pangandaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
<div class="container">
    <a class="navbar-brand" href="#">Pangandaran Trip</a>
    <div class="navbar-nav ms-auto">
        <a class="nav-link active" href="index.php">Beranda</a>
        <a class="nav-link" href="pemesanan.php">Daftar Paket</a>
        <a class="nav-link" href="modifikasi_pesanan.php">Modifikasi Pesanan</a>
    </div>
</div>
</nav>

<div class="hero-section">
    <div>
        <h1 class="display-4 fw-bold">Explore Pangandaran</h1>
        <p class="lead">Surga Tersembunyi di Jawa Barat</p>
        <a href="#paket" class="btn btn-warning btn-lg rounded-pill shadow">Lihat Paket</a>
    </div>
</div>

<div class="container my-5" id="paket">
    <h2 class="text-center mb-5 fw-bold" style="color: var(--primary-green);">Paket Wisata Populer</h2>
    <div class="row">
        <?php
        $query = "SELECT * FROM paket_wisata";
        $result = mysqli_query($koneksi, $query);
        while($row = mysqli_fetch_assoc($result)) {
            // Logika Mengubah Link Youtube Biasa menjadi Embed
            $video_url = $row['link_video'];
            $embed_url = str_replace("watch?v=", "embed/", $video_url);
        ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-wisata h-100 shadow-sm">
                <img src="img/<?php echo $row['gambar']; ?>" class="card-img-top" alt="Foto Wisata">
                
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nama_paket']; ?></h5>
                    
                    <div class="video-container mt-3">
                        <iframe src="<?php echo $embed_url; ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    
                    <p class="card-text text-muted small mt-2"><?php echo $row['deskripsi']; ?></p>
                    <a href="pemesanan.php?paket=<?php echo urlencode($row['nama_paket']); ?>" class="btn btn-alam w-100 mt-auto">Booking Sekarang</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<footer class="footer-alam">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-uppercase mb-3">Wisata Pangandaran</h5>
                <p class="small text-white-50">
                    Platform resmi pemesanan paket wisata terbaik di Pangandaran. 
                    Kami menyediakan pengalaman liburan alam yang tak terlupakan 
                    mulai dari Green Canyon hingga Pantai Pasir Putih.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-uppercase mb-3">Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="index.php" class="footer-link">Beranda</a></li>
                    <li class="mb-2"><a href="#paket" class="footer-link">Daftar Paket Wisata</a></li>
                    <li class="mb-2"><a href="pemesanan.php" class="footer-link">Form Pemesanan</a></li>
                    <li class="mb-2"><a href="modifikasi_pesanan.php" class="footer-link">Cek Pesanan Saya</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-uppercase mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-3">
                        <i class="fas fa-map-marker-alt me-2 text-warning"></i> 
                        Jl. Pantai Barat No. 123, Pangandaran, Jawa Barat
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone me-2 text-warning"></i> 
                        +62 812-3456-7890
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-envelope me-2 text-warning"></i> 
                        pangandaran@gmail.com
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom text-center py-3">
        <small>&copy; 2025 Wisata Pangandaran. All Rights Reserved. | Tugas Capstone Project</small>
    </div>
</footer>

</body>
</html>