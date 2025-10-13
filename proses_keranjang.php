<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$payload = json_decode(file_get_contents('php://input'), true);
$aksi = $payload['aksi'] ?? '';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($aksi == 'tambah') {
  $id = (int)$payload['id'];
  $nama = esc($payload['nama']);
  $harga = (float)$payload['harga'];
  $lensa = esc($payload['lensa']);
  $jumlah = max(1,(int)$payload['jumlah']);

  // ambil gambar produk
  $img = 'placeholder.png';
  $res = mysqli_prepare($koneksi,"SELECT gambar FROM produk WHERE id=?");
  if($res){
    mysqli_stmt_bind_param($res,'i',$id);
    mysqli_stmt_execute($res);
    mysqli_stmt_bind_result($res,$g);
    if(mysqli_stmt_fetch($res)) if($g) $img=$g;
    mysqli_stmt_close($res);
  }

  if(isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['jumlah'] += $jumlah;
  else $_SESSION['cart'][$id]=['id'=>$id,'nama'=>$nama,'harga'=>$harga,'jumlah'=>$jumlah,'lensa'=>$lensa,'gambar'=>$img];

  $totalJumlah = array_sum(array_column($_SESSION['cart'],'jumlah'));
  echo json_encode(['success'=>true,'totalJumlah'=>$totalJumlah,'items'=>array_values($_SESSION['cart'])]);
  exit;
}

if($aksi=='lihat'){
  echo json_encode(['items'=>array_values($_SESSION['cart'])]);
  exit;
}

// fallback: hapus via form
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['aksi']) && $_POST['aksi']==='hapus'){
  $id=(int)$_POST['id'];
  if(isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
  header('Location: keranjang.php'); exit;
}

echo json_encode(['success'=>false,'msg'=>'aksi tidak dikenali']);
