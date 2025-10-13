<?php
require_once __DIR__ . '/../koneksi.php';
if (isset($_SESSION['admin_id'])) { header('Location: dasbor.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $result = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($result);
    if ($admin && ((function_exists('password_verify') && password_verify($password, $admin['password'])) || md5($password) === $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: dasbor.php'); exit;
    } else { $error = 'Username atau password salah.'; }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login Admin - Wink Optik</title>
<link rel="stylesheet" href="../style/style.css">
<style>
body { display:flex; justify-content:center; align-items:center; min-height:100vh; background:linear-gradient(135deg,#ffeef7,#fff3f7);}
.card { padding:24px; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.08); background:white; width:100%; max-width:400px; }
.card h2 { margin-bottom:12px; }
input, textarea { width:100%; padding:8px 10px; margin:4px 0 12px 0; border-radius:6px; border:1px solid #ccc; }
.button { background:linear-gradient(135deg,#ff8eb3,#ff70a6); color:white; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:600; }
.button:hover { opacity:.9; }
.small { font-size:13px; color:#666; text-decoration:none; }
</style>
</head>
<body>
<div class="card">
<h2>Admin Wink Optik</h2>
<?php if($error) echo '<p style="color:#c33">'.htmlspecialchars($error).'</p>'; ?>
<form method="post">
  <label>Username</label>
  <input name="username" required>
  <label>Password</label>
  <input type="password" name="password" required>
  <div style="display:flex;justify-content:space-between;align-items:center;">
    <button class="button" type="submit">Login</button>
    <a href="../index.php" class="small">🏠 Kembali ke toko</a>
  </div>
</form>
</div>
</body>
</html>
