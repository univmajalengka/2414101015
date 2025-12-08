<?php
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$rProduk = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM produk");
$jmlProduk = (int)mysqli_fetch_assoc($rProduk)['jml'];

$rPesanan = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pesanan");
$jmlPesanan = (int)mysqli_fetch_assoc($rPesanan)['jml'];

$rPendapatan = mysqli_query($koneksi, "SELECT IFNULL(SUM(total),0) AS totalPendapatan FROM pesanan");
$totalPendapatan = (float)mysqli_fetch_assoc($rPendapatan)['totalPendapatan'];

$rTerbaru = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY waktu_pemesanan DESC LIMIT 5");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dasbor Admin - Wink Optik</title>
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
.stats {
  display:flex;
  gap:16px;
  flex-wrap:wrap;
  margin-bottom:18px;
}
.stat-card {
  flex:1 1 220px;
  background:linear-gradient(135deg,#fff3f7,#ffeef7);
  padding:18px;
  border-radius:12px;
  box-shadow:0 8px 24px rgba(0,0,0,0.06);
}
.stat-card h3 {
  margin:0 0 8px 0;
  font-size:14px;
  color:#555;
}
.stat-card .value {
  font-size:22px;
  font-weight:700;
}
.revenue {
  border:1px solid rgba(255,150,170,0.12);
}
.revenue .icon{
  font-size:34px;
  opacity:.9;
}
.animate-pop{
  transform-origin:center;
  animation:pop .6s 
  cubic-bezier(.2,.9,.3,1);
}
@keyframes pop{from{opacity:0;transform:translateY(8px) scale(.98)}to{opacity:1;transform:none}}
table.pesanan{width:100%;border-collapse:collapse;margin-top:12px;}
table.pesanan th,table.pesanan td{padding:8px 10px;border-bottom:1px solid rgba(0,0,0,0.06);text-align:left;font-size:14px;}
.small{font-size:13px;color:#666;}
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
<main class="container card">
<h2>👋 Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h2>
<div class="stats">
  <div class="stat-card"><h3>Total Produk</h3><div class="value"><?php echo number_format($jmlProduk); ?></div></div>
  <div class="stat-card"><h3>Total Pesanan</h3><div class="value"><?php echo number_format($jmlPesanan); ?></div></div>
  <div class="stat-card revenue">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <div><h3>Total Pendapatan</h3>
      <div class="value" id="revenue-counter" data-target="<?php echo (int)$totalPendapatan; ?>">Rp 0</div>
      <div class="small">Semua pesanan</div></div>
      <div class="icon">💰</div>
    </div>
  </div>
</div>

<h3>📄 Pesanan Terbaru</h3>
<table class="pesanan">
<thead><tr><th>#</th><th>Nama</th><th>Total</th><th>Waktu</th><th>Catatan</th></tr></thead>
<tbody>
<?php while($o = mysqli_fetch_assoc($rTerbaru)): ?>
<tr>
<td><?php echo $o['id']; ?></td>
<td><?php echo htmlspecialchars($o['nama_pembeli']); ?></td>
<td>Rp <?php echo number_format($o['total'],0,',','.'); ?></td>
<td class="small"><?php echo $o['waktu_pemesanan']; ?></td>
<td class="small"><?php echo htmlspecialchars(mb_strimwidth($o['catatan'],0,60,'...')); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</main>
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    const el=document.getElementById('revenue-counter');
    if(!el) return;
    const target=parseInt(el.dataset.target,10)||0;
    const start=0; const duration=1400; let startTime=null;
    function formatRupiah(n){return 'Rp '+n.toLocaleString('id-ID');}
    function step(timestamp){ if(!startTime) startTime=timestamp;
      const progress=Math.min((timestamp-startTime)/duration,1);
      const value=Math.floor(progress*(target-start)+start);
      el.textContent=formatRupiah(value);
      if(progress<1) window.requestAnimationFrame(step);
      else el.textContent=formatRupiah(target);
    }
    window.requestAnimationFrame(step);
});
</script>
</body>
</html>
