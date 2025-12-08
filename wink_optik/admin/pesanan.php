<?php
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$r = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY waktu_pemesanan DESC");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pesanan - Wink Optik</title>
<link rel="stylesheet" href="../style/style.css">
<style>
.brand {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 24px;
    color: #000000ff;
}
.brand span {
    color: #ffb6c1;
}
.nav a {
    text-decoration: none;
    color: #444;
    font-weight: 600;
    margin-right: 16px;
}
.nav a:hover {
    color: var(--primary);
}
.nav a::before {
    margin-right: 6px;
}
.card { padding:16px; border-radius:12px; background:linear-gradient(135deg,#fff3f7,#ffeef7); margin-bottom:16px; box-shadow:0 8px 24px rgba(0,0,0,0.06);}
.small { font-size:13px; color:#666; }
.button { background:linear-gradient(135deg,#ff8eb3,#ff70a6); color:white; border:none; padding:8px 12px; border-radius:8px; cursor:pointer; font-weight:600; text-decoration:none; display:inline-block;}
.button:hover { opacity:.9; }
</style>
</head>
<body class="fade-in">
<header class="nav">
    <div class="brand">Wink <span>Optik</span></div>
    <nav>
        <a href="dasbor.php">🏠 Dasbor</a>
        <a href="produk.php">👜 Produk</a>
        <a href="pesanan.php">📦 Pesanan</a>
        <a href="pengaturan_admin.php">⚙️ Pengaturan</a>
        <a href="logout.php">🔓 Logout</a>
    </nav>
</header>
<main class="container">
<h2>📦 Pesanan Masuk</h2>
<?php while($o = mysqli_fetch_assoc($r)): ?>
<div class="card">
<strong>Order #<?php echo $o['id']; ?></strong> — <span class="small"><?php echo $o['waktu_pemesanan']; ?></span><br>
Nama: <?php echo htmlspecialchars($o['nama_pembeli']); ?><br>
Alamat: <?php echo nl2br(htmlspecialchars($o['alamat'])); ?><br>
No HP: <?php echo htmlspecialchars($o['no_hp']); ?><br>
Catatan: <?php echo htmlspecialchars($o['catatan']); ?><br>
Total: Rp <?php echo number_format($o['total'],0,',','.'); ?><br>
<a href="aksi.php?aksi=detail&id=<?php echo $o['id']; ?>" class="button">Lihat Detail 📝</a>
</div>
<?php endwhile; ?>
</main>
</body>
</html>
