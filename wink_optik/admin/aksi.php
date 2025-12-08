<?php
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$aksi = $_GET['aksi'] ?? '';
if ($aksi === 'detail') {
    $id = (int)($_GET['id'] ?? 0);
    $r = mysqli_query($koneksi, "SELECT dp.*, p.gambar FROM detail_pesanan dp LEFT JOIN produk p ON p.id = dp.produk_id WHERE id_pesanan=" . $id);
    echo '<!doctype html><html><head><meta charset="utf-8"><title>Detail Pesanan</title><link rel="stylesheet" href="../style/style.css">
    <style>
    .card { padding:16px; border-radius:12px; background:linear-gradient(135deg,#fff3f7,#ffeef7); margin-top:16px; box-shadow:0 8px 24px rgba(0,0,0,0.06);}
    img { height:80px; object-fit:cover; border-radius:6px; margin-right:8px;}
    ul { list-style:none; padding:0;}
    li { display:flex; align-items:center; margin-bottom:10px;}
    .button { background:linear-gradient(135deg,#ff8eb3,#ff70a6); color:white; border:none; padding:8px 12px; border-radius:8px; text-decoration:none; font-weight:600;}
    .button:hover { opacity:.9;}
    </style>
    </head><body class="fade-in"><div class="container card">';
    echo '<h3>📋 Detail Pesanan #' . $id . '</h3><ul>';
    while($d = mysqli_fetch_assoc($r)) {
        echo '<li><img src="../images/' . htmlspecialchars($d['gambar']) . '"> ' . htmlspecialchars($d['nama_produk']) . ' — Lensa: ' . htmlspecialchars($d['lensa']) . ' — Jumlah: ' . (int)$d['jumlah'] . ' — Harga: Rp ' . number_format($d['harga_satuan'],0,',','.') . '</li>';
    }
    echo '</ul><p><a href="pesanan.php" class="button">⬅️ Kembali</a></p></div></body></html>';
    exit;
}

header('Location: pesanan.php');
exit;
