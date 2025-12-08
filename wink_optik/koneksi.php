<?php
// koneksi.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'wink_optik';

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}

if (session_status() == PHP_SESSION_NONE) session_start();

function esc($s){ global $koneksi; return mysqli_real_escape_string($koneksi, trim($s)); }
?>
