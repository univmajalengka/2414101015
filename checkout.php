<?php
require_once 'koneksi.php';
if (empty($_SESSION['cart'])) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = esc($_POST['nama']);
    $alamat = esc($_POST['alamat']);
    $nohp = esc($_POST['nohp']);
    $catatan = esc($_POST['catatan']);

    $total = 0;
    foreach($_SESSION['cart'] as $it) $total += $it['harga'] * $it['jumlah'];

    mysqli_autocommit($koneksi, FALSE); // start transaction
    try {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO pesanan (nama_pembeli, alamat, no_hp, catatan, total) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssd', $nama, $alamat, $nohp, $catatan, $total);
        mysqli_stmt_execute($stmt);
        $order_id = mysqli_insert_id($koneksi);
        mysqli_stmt_close($stmt);

        // INSERT multi-row untuk detail pesanan
        $values = [];
        foreach($_SESSION['cart'] as $it) {
            $n = mysqli_real_escape_string($koneksi, $it['nama']);
            $l = mysqli_real_escape_string($koneksi, $it['lensa']);
            $values[] = "($order_id, {$it['id']}, '$n', '$l', {$it['jumlah']}, {$it['harga']})";
        }
        if ($values) {
            $sql = "INSERT INTO detail_pesanan (id_pesanan, produk_id, nama_produk, lensa, jumlah, harga_satuan) VALUES " . implode(',', $values);
            mysqli_query($koneksi, $sql);
        }

        mysqli_commit($koneksi);
        $_SESSION['cart'] = [];
        header('Location: pesanan_berhasil.php?id=' . $order_id);
        exit;
    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        die("Gagal memproses pesanan: " . $e->getMessage());
    }
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Checkout - Wink Optik</title>
<link rel="stylesheet" href="style/style.css">
<style>
.card { max-width: 500px; margin: 24px auto; padding: 24px; border-radius: 12px; background: var(--card); box-shadow: 0 8px 30px rgba(16,24,40,0.04);}
.checkout-form .form-group { margin-bottom: 16px; }
.checkout-form label { display: block; margin-bottom: 6px; font-weight: 600; }
.checkout-form input, .checkout-form textarea { width: 100%; padding: 10px 12px; border-radius: 8px; border:1px solid #ccc; font-size: 14px; transition:border 0.2s;}
.checkout-form input:focus, .checkout-form textarea:focus { border-color: var(--accent-a); outline:none; }
.checkout-form button { width: 100%; padding: 12px; border-radius:10px; border:none; background: linear-gradient(90deg,var(--accent-a),var(--accent-b)); color:#fff; font-weight:700; cursor:pointer; transition:background 0.2s; }
.checkout-form button:hover { background:#e05595; }
</style>
</head>
<body class="fade-in">
<header class="nav"><div class="brand">Wink <span>Optik</span></div></header>
<main class="container card">
<h2>Form Checkout</h2>
<form method="post" class="checkout-form">
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input name="nama" required>
    </div>
    <div class="form-group">
        <label>Alamat Lengkap</label>
        <textarea name="alamat" required></textarea>
    </div>
    <div class="form-group">
        <label>No HP</label>
        <input name="nohp" required>
    </div>
    <div class="form-group">
        <label>Catatan (isi minus/plus/silinder)</label>
        <textarea name="catatan"></textarea>
    </div>
    <button type="submit">Proses Pembayaran</button>
</form>
</main>
</body>
</html>
