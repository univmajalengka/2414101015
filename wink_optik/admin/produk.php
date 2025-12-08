<?php
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$err = '';

// Tambah Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'tambah') {
    $nama = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $des = mysqli_real_escape_string($koneksi, trim($_POST['deskripsi']));
    $harga = (float)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $gambar = 'placeholder.png';

    if (!empty($_FILES['gambar']['name'])) {
        $tmp = $_FILES['gambar']['tmp_name'];
        $mime = mime_content_type($tmp);
        if ($mime !== 'image/png') { $err = 'Hanya file PNG yang diizinkan'; }
        else {
            $namaFile = time() . '_' . preg_replace('/[^a-z0-9_\-\.]/i','_', $_FILES['gambar']['name']);
            $tujuan = __DIR__ . '/../images/' . $namaFile;
            if (move_uploaded_file($tmp, $tujuan)) $gambar = $namaFile;
        }
    }

    if (empty($err)) {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO produk (nama, deskripsi, harga, stok, gambar) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssdis', $nama, $des, $harga, $stok, $gambar);
        mysqli_stmt_execute($stmt);
        header('Location: produk.php'); exit;
    }
}

// Edit Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'edit') {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $des = mysqli_real_escape_string($koneksi, trim($_POST['deskripsi']));
    $harga = (float)$_POST['harga'];
    $stok = (int)$_POST['stok'];

    $r = mysqli_query($koneksi, "SELECT * FROM produk WHERE id=" . $id);
    $p = mysqli_fetch_assoc($r);
    $gambar = $p['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $tmp = $_FILES['gambar']['tmp_name'];
        $mime = mime_content_type($tmp);
        if ($mime !== 'image/png') { $err = 'Hanya file PNG yang diizinkan'; }
        else {
            if (!empty($p['gambar']) && file_exists(__DIR__ . '/../images/' . $p['gambar']) && $p['gambar'] !== 'placeholder.png') {
                @unlink(__DIR__ . '/../images/' . $p['gambar']);
            }
            $namaFile = time() . '_' . preg_replace('/[^a-z0-9_\-\.]/i','_', $_FILES['gambar']['name']);
            $tujuan = __DIR__ . '/../images/' . $namaFile;
            if (move_uploaded_file($tmp, $tujuan)) $gambar = $namaFile;
        }
    }

    if (empty($err)) {
        $stmt = mysqli_prepare($koneksi, "UPDATE produk SET nama=?, deskripsi=?, harga=?, stok=?, gambar=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'ssdisi', $nama, $des, $harga, $stok, $gambar, $id);
        mysqli_stmt_execute($stmt);
        header('Location: produk.php'); exit;
    }
}

// Hapus Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    $id = (int)$_POST['id'];
    $r = mysqli_query($koneksi, "SELECT * FROM produk WHERE id=" . $id);
    $p = mysqli_fetch_assoc($r);
    if ($p && !empty($p['gambar']) && file_exists(__DIR__ . '/../images/' . $p['gambar']) && $p['gambar'] !== 'placeholder.png') {
        @unlink(__DIR__ . '/../images/' . $p['gambar']);
    }
    mysqli_query($koneksi, "DELETE FROM produk WHERE id=" . $id);
    header('Location: produk.php'); exit;
}

$r = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY dibuat DESC");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kelola Produk - Wink Optik</title>
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
.product-img { height:120px; object-fit:cover; border-radius:6px; }
.details-img { height:180px; object-fit:cover; border-radius:6px; margin-bottom:8px; }
.card form input, .card form textarea { width:100%; padding:8px 10px; margin-bottom:10px; border-radius:6px; border:1px solid #ccc; }
.button { background:linear-gradient(135deg,#ff8eb3,#ff70a6); color:white; border:none; padding:10px 14px; border-radius:8px; cursor:pointer; font-weight:600; }
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
<main class="container card">
<h2>👜 Tambah Produk</h2>
<?php if(!empty($err)) echo '<p style="color:red">'.htmlspecialchars($err).'</p>'; ?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="aksi" value="tambah">
<label>Nama</label><input name="nama" required>
<label>Deskripsi</label><textarea name="deskripsi"></textarea>
<label>Harga</label><input name="harga" type="number" required>
<label>Stok</label><input name="stok" type="number" value="0">
<label>Gambar (.png)</label><input name="gambar" type="file" accept="image/png">
<button class="button" type="submit">Tambah</button>
</form>

<h3>📄 Daftar Produk</h3>
<table>
<thead><tr><th>ID</th><th>Gambar</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
<tbody>
<?php while($p = mysqli_fetch_assoc($r)): ?>
<tr>
<td><?php echo $p['id']; ?></td>
<td><img src="../images/<?php echo htmlspecialchars($p['gambar']); ?>" class="product-img"></td>
<td><?php echo htmlspecialchars($p['nama']); ?></td>
<td>Rp <?php echo number_format($p['harga'],0,',','.'); ?></td>
<td><?php echo $p['stok']; ?></td>
<td>
<details>
<summary style="cursor:pointer">✏️ Edit</summary>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="aksi" value="edit">
<input type="hidden" name="id" value="<?php echo $p['id']; ?>">
<label>Nama</label><input name="nama" value="<?php echo htmlspecialchars($p['nama']); ?>" required>
<label>Deskripsi</label><textarea name="deskripsi"><?php echo htmlspecialchars($p['deskripsi']); ?></textarea>
<label>Harga</label><input name="harga" type="number" value="<?php echo $p['harga']; ?>" required>
<label>Stok</label><input name="stok" type="number" value="<?php echo $p['stok']; ?>">
<label>Ganti Gambar (.png)</label>
<img src="../images/<?php echo htmlspecialchars($p['gambar']); ?>" class="details-img">
<input name="gambar" type="file" accept="image/png">
<button class="button" type="submit">Simpan</button>
</form>
</details>
<form method="post" style="display:inline;margin-top:6px;">
<input type="hidden" name="aksi" value="hapus">
<input type="hidden" name="id" value="<?php echo $p['id']; ?>">
<button class="button" type="submit">Hapus</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</main>
</body>
</html>
