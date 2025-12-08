<?php
require_once 'koneksi.php';
$id = (int)($_GET['id'] ?? 0);
$pes = null;
if ($id) {
    $r = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id=" . $id);
    $pes = mysqli_fetch_assoc($r);
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sukses - Wink Optik</title>
<link rel="stylesheet" href="style/style.css">
<style>
.card { max-width:500px; margin:24px auto; padding:24px; border-radius:12px; background:var(--card); box-shadow:0 8px 30px rgba(16,24,40,0.04); text-align:center;}
.pesanan-success h2 { color: #4caf50; margin-bottom:12px;}
.pesanan-success p { margin-bottom:8px; }
.pesanan-success .button { display:inline-block; margin-top:16px; padding:12px 24px; border-radius:10px; background: linear-gradient(90deg,var(--accent-a),var(--accent-b)); color:#fff; text-decoration:none;}
</style>
</head>
<body class="fade-in">
<div class="container card pesanan-success">
<h2>Terima Kasih — Pesanan Anda Diterima</h2>
<?php if ($pes): ?>
    <p>Nomor Pesanan: #<?php echo $pes['id']; ?></p>
    <p>Nama: <?php echo htmlspecialchars($pes['nama_pembeli']); ?></p>
    <p>Total: Rp <?php echo number_format($pes['total'],0,',','.'); ?></p>
    <p>Waktu Pesan: <?php echo $pes['waktu_pemesanan']; ?></p>
<?php else: ?>
    <p>Pesanan tidak ditemukan.</p>
<?php endif; ?>
<a href="index.php" class="button">Kembali ke Toko</a>
</div>
</body>
</html>
