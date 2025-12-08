<?php
require_once 'koneksi.php';
$items = $_SESSION['cart'] ?? [];
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Keranjang - Wink Optik</title>
<link rel="stylesheet" href="style/style.css"></head><body class="fade-in">
<header class="nav"><div class="brand">Wink <span>Optik</span></div><nav><a href="index.php">Home</a><a href="index.php#produk">Produk</a></nav></header>
<main class="container card">
  <h2>Keranjang Anda</h2>
  <?php if(empty($items)): ?>
    <p>Keranjang kosong.</p>
  <?php else: ?>
    <ul>
    <?php $total = 0; foreach($items as $it): $subtotal = $it['harga']*$it['jumlah']; $total += $subtotal; ?>
      <li>
        <?php echo htmlspecialchars($it['nama']); ?> — Lensa: <?php echo htmlspecialchars($it['lensa']); ?> — <?php echo $it['jumlah']; ?> x Rp <?php echo number_format($it['harga'],0,',','.'); ?> = Rp <?php echo number_format($subtotal,0,',','.'); ?>
        <form action="proses_keranjang.php" method="post" style="display:inline">
          <input type="hidden" name="aksi" value="hapus">
          <input type="hidden" name="id" value="<?php echo $it['id']; ?>">
          <button type="submit">Hapus</button>
        </form>
      </li>
    <?php endforeach; ?>
    </ul>
    <p><strong>Total: Rp <?php echo number_format($total,0,',','.'); ?></strong></p>
    <a href="checkout.php" class="button">Lanjut ke Checkout</a>
  <?php endif; ?>
</main>
</body></html>
