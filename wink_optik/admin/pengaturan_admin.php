<?php
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$pesan = '';
$id = $_SESSION['admin_id'];
$result = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id'");
$admin = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_baru = trim($_POST['username_baru']);
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['password_konfirmasi'];

    if (!password_verify($password_lama, $admin['password']) && md5($password_lama) !== $admin['password']) {
        $pesan = '<span style="color:red;">❌ Password lama salah!</span>';
    } else {
        if ($username_baru !== $admin['username'] && $username_baru !== '') {
            mysqli_query($koneksi, "UPDATE admin SET username='" . mysqli_real_escape_string($koneksi,$username_baru) . "' WHERE id_admin='$id'");
            $_SESSION['admin_username'] = $username_baru;
        }
        if ($password_baru !== '') {
            if ($password_baru === $konfirmasi) {
                $hash = password_hash($password_baru, PASSWORD_DEFAULT);
                mysqli_query($koneksi, "UPDATE admin SET password='" . mysqli_real_escape_string($koneksi,$hash) . "' WHERE id_admin='$id'");
                $pesan = '<span style="color:green;">✅ Username/Password berhasil diperbarui!</span>';
            } else {
                $pesan = '<span style="color:red;">❌ Konfirmasi password tidak sama!</span>';
            }
        } else {
            $pesan = '<span style="color:green;">✅ Username berhasil diperbarui!</span>';
        }
    }
    $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id'");
    $admin = mysqli_fetch_assoc($result);
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pengaturan Admin - Wink Optik</title>
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
.card { padding:16px; border-radius:12px; background:linear-gradient(135deg,#fff3f7,#ffeef7); margin-top:16px; box-shadow:0 8px 24px rgba(0,0,0,0.06);}
input { width:100%; padding:8px 10px; margin-bottom:12px; border-radius:6px; border:1px solid #ccc; }
.button { background:linear-gradient(135deg,#ff8eb3,#ff70a6); color:white; border:none; padding:10px 14px; border-radius:8px; cursor:pointer; font-weight:600;}
.button:hover { opacity:.9; }
.small { font-size:13px; }
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
<h2>⚙️ Pengaturan Admin</h2>
<?php if($pesan) echo "<p class='small'>$pesan</p>"; ?>
<form method="POST">
<label>Username Saat Ini</label>
<input type="text" value="<?= htmlspecialchars($admin['username']); ?>" disabled>
<label>Username Baru</label>
<input type="text" name="username_baru" placeholder="Isi jika ingin ubah username">
<label>Password Lama</label>
<input type="password" name="password_lama" required placeholder="Masukkan password lama">
<label>Password Baru</label>
<input type="password" name="password_baru" placeholder="Isi jika ingin ubah password">
<label>Konfirmasi Password Baru</label>
<input type="password" name="password_konfirmasi" placeholder="Ulangi password baru">
<button class="button" type="submit">Simpan Perubahan</button>
</form>
</main>
</body>
</html>
