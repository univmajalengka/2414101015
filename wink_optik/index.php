<?php
require_once 'koneksi.php';
$q = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY dibuat DESC");
$produk = [];
while($r = mysqli_fetch_assoc($q)) $produk[] = $r;
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Wink Optik - Beranda</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style/style.css">
</head>
<body class="fade-in">

<!-- NAVBAR -->
<header class="nav">
  <div class="nav-left">
    <a class="logo" href="index.php" aria-label="Wink Optik">
      <?php if(file_exists(__DIR__ . '/images/logo.png')): ?>
        <img src="images/logo.png" alt="Wink Optik" class="logo-img" style="height:44px;">
      <?php else: ?>
        <!-- fallback: inline SVG -->
        <svg class="logo-mark" width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
          <defs><linearGradient id="g1" x1="0" x2="1" y1="0" y2="1"><stop offset="0" stop-color="#ffdff6"/><stop offset="1" stop-color="#dff7ff"/></linearGradient></defs>
          <rect rx="10" width="44" height="44" fill="url(#g1)"/>
          <g transform="translate(6,13)" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="6" cy="8" r="6" fill="rgba(255,255,255,0.15)"/>
            <circle cx="26" cy="8" r="6" fill="rgba(255,255,255,0.15)"/>
            <path d="M12 8h10" />
          </g>
        </svg>
      <?php endif; ?>
      <span class="logo-text">Wink <strong>Optik</strong></span>
    </a>
  </div>

  <div class="nav-center">
    <nav class="nav-links">
      <a href="index.php" class="nav-link"><span class="ico">🏠</span>Home</a>
      <a href="#produk" class="nav-link"><span class="ico">🕶️</span>Produk</a>
      <a href="#tentang" class="nav-link"><span class="ico">ℹ️</span>Tentang</a>
      <a href="#kontak" class="nav-link"><span class="ico">📞</span>Kontak</a>
    </nav>
  </div>

  <div class="nav-right">
    <button id="cart-btn" class="cart-btn" aria-label="Buka Keranjang">
      <span class="cart-ico">🛒</span>
      <span id="cart-count" class="cart-count"><?php echo isset($_SESSION['cart'])?array_sum(array_column($_SESSION['cart'],'jumlah')):0; ?></span>
    </button>

    <!-- Admin icon: tampil selalu di pojok kanan atas -->
    <a href="admin/login.php" id="admin-icon" class="icon-btn" title="Admin">👤</a>
  </div>
</header>

<!-- BANNER (di bawah navbar) -->
<section class="banner-area">
  <div class="container banner-inner">
    <div class="banner-visual">
      <?php if(file_exists(__DIR__ . '/images/banner.png')): ?>
        <img src="images/banner.png" class="banner-img" alt="Banner Wink Optik">
      <?php else: ?>
        <img src="images/placeholder.png" class="banner-img" alt="Banner Wink Optik">
      <?php endif; ?>
      <div class="banner-overlay">
        <h1>✨WINK OPTIK✨</h1>
        <p class="lead">Kacamata Stylish & Berkualitas</p>
      </div>
    </div>
  </div>
</section>

<!-- MAIN -->
<main class="container">
  <section id="produk" class="card products-section">
    <div class="section-header">
      <h2>Produk Unggulan Wink</h2>
      <p class="small">Klik produk untuk membeli</p>
    </div>

    <div class="grid products-grid">
      <?php foreach($produk as $p): ?>
      <article class="produk-card" tabindex="0" data-id="<?php echo $p['id']; ?>"
               data-nama="<?php echo htmlspecialchars($p['nama']); ?>"
               data-harga="<?php echo $p['harga']; ?>"
               data-gambar="images/<?php echo htmlspecialchars($p['gambar']); ?>">
        <div class="produk-media">
          <img src="images/<?php echo htmlspecialchars($p['gambar']); ?>" alt="<?php echo htmlspecialchars($p['nama']); ?>">
        </div>
        <div class="produk-body">
          <h3 class="produk-title"><?php echo htmlspecialchars($p['nama']); ?></h3>
          <div class="produk-price">Rp <?php echo number_format($p['harga'],0,',','.'); ?></div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="tentang" class="card about-section">
    <h2>Tentang Wink Optik</h2>
    <p>Wink Optik menyediakan kacamata fashion & lensa berkualitas, dengan pilihan lensa yang sesuai kebutuhan: Anti Radiasi, Blueray, Photochromic, Bluecromic.
    Pelayanan yang cepat, pengemasan aman, serta garansi jika produk cacat.</p>
  </section>

  <section id="kontak" class="card contact-section">
    <h2>Kontak</h2>
    <p>📍Alamat: Jl. Matahari No.10, Mekar Sari, Majalengka.</p>
    <p>📞WhatsApp: +62 812-3456-7890</p>
    <p>📩Email: winkoptik@gmail.com</p>
  </section>
</main>

<!-- CART SIDEBAR -->
<aside id="cart-sidebar" class="cart-sidebar" aria-hidden="true">
  <div class="cart-header">
    <h3>Keranjang</h3>
    <button id="close-cart" class="close-cart" aria-label="Tutup Keranjang">✕</button>
  </div>
  <div id="cart-items" class="cart-items">
    <p class="small muted">Memuat keranjang...</p>
  </div>
  <div class="cart-footer">
    <div class="subtotal">
      <span>Subtotal</span>
      <strong id="cart-subtotal">Rp 0</strong>
    </div>
    <a href="checkout.php" class="button full checkout-btn">Lanjut ke Checkout</a>
  </div>
</aside>

<!-- PRODUCT MODAL -->
<div id="product-modal" class="modal" aria-hidden="true">
  <div class="modal-backdrop"></div>
  <div class="modal-panel">
    <button class="modal-close" id="modal-close" aria-label="Tutup">✕</button>
    <div class="modal-content">
      <div class="modal-media"><img id="modal-img" src="images/placeholder.png" alt=""></div>
      <div class="modal-body">
        <h3 id="modal-name">Nama Produk</h3>
        <div id="modal-price" class="modal-price">Rp 0</div>
        <label>Pilih Lensa</label>
        <select id="modal-lensa">
          <option>Anti Radiasi</option>
          <option>Blueray</option>
          <option>Photochromic</option>
          <option>Bluecromic</option>
        </select>
        <label>Jumlah</label>
        <div class="qty-row">
          <button id="qty-dec" class="qty-btn">−</button>
          <input id="modal-qty" type="number" value="1" min="1">
          <button id="qty-inc" class="qty-btn">+</button>
        </div>
        <button id="add-to-cart" class="button full">Tambah ke Keranjang</button>
      </div>
    </div>
  </div>
</div>

<footer class="footer">
  <div class="footer-inner">
    <p>© 2025 Wink Optik — Semua hak dilindungi.</p>
    <p class="small">Ikuti kami:
      <a href="https://instagram.com/Optik_Wink" target="_blank">Instagram</a> |
      <a href="https://tiktok.com/@Optik_Wink30" target="_blank">TikTok</a> |
      <a href="https://facebook.com/Optik_Wink" target="_blank">Facebook</a>
    </p>
  </div>
</footer>

<script src="script/script.js"></script>
</body>
</html>
