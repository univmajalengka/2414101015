<?php include 'koneksi.php'; 

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id_pesanan='$id'");
    echo "<script>alert('Data Terhapus!'); window.location='modifikasi_pesanan.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-dark navbar-custom mb-4">
<div class="container">
    <span class="navbar-brand">Data Pesanan Masuk</span>
    <div class="d-flex gap-2">
        <a href="index.php" class="btn btn-outline-light btn-sm">Beranda</a>
        <a href="pemesanan.php" class="btn btn-light btn-sm text-success fw-bold">+ Tambah Pesanan</a>
    </div>
</div>
</nav>

<div class="container">
    <div class="card shadow p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Phone</th>
                        <th>Peserta</th>
                        <th>Hari</th>
                        <th>Layanan</th>
                        <th>Total Tagihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM pemesanan ORDER BY id_pesanan DESC");
                    while($r = mysqli_fetch_array($q)){
                        // Tampilkan layanan apa saja yang dipilih
                        $layanan = [];
                        if($r['layanan_penginapan']) $layanan[] = "Inap";
                        if($r['layanan_transport']) $layanan[] = "Trans";
                        if($r['layanan_makan']) $layanan[] = "Makan";
                    ?>
                    <tr>
                        <td><?php echo $r['nama_pemesan']; ?></td>
                        <td><?php echo $r['no_hp']; ?></td>
                        <td><?php echo $r['jumlah_peserta']; ?> Org</td>
                        <td><?php echo $r['waktu_pelaksanaan']; ?> Hari</td>
                        <td><?php echo implode(", ", $layanan); ?></td>
                        <td class="fw-bold">Rp <?php echo number_format($r['total_tagihan']); ?></td>
                        <td>
                            <a href="pemesanan.php?edit=<?php echo $r['id_pesanan']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="modifikasi_pesanan.php?hapus=<?php echo $r['id_pesanan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>