<?php
include 'koneksi.php';

$nama = ""; $phone = ""; $tgl = ""; $hari = 1; $peserta = 1;
$inap = 0; $transport = 0; $makan = 0; 
$harga_paket = 0; $tagihan = 0; $id_edit = "";

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $q = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id_pesanan = '$id_edit'");
    if (mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_array($q);
        $nama = $data['nama_pemesan'];
        $phone = $data['no_hp'];
        $tgl = $data['tgl_pesan'];
        $hari = $data['waktu_pelaksanaan'];
        $peserta = $data['jumlah_peserta'];
        $inap = $data['layanan_penginapan'];
        $transport = $data['layanan_transport'];
        $makan = $data['layanan_makan'];
        $harga_paket = $data['harga_paket'];
        $tagihan = $data['total_tagihan'];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-dark navbar-custom mb-4">
<div class="container">
    <span class="navbar-brand">Form Pemesanan</span>
    <a href="index.php" class="btn btn-outline-light btn-sm">Kembali</a>
</div>
</nav>

<div class="container pb-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center"><?php echo ($id_edit != "") ? "Edit Pesanan" : "Form Pemesanan Baru"; ?></h3>
        
        <form action="proses_simpan.php" method="POST" onsubmit="return validateForm()">
            
            <input type="hidden" name="id_pesanan" value="<?php echo $id_edit; ?>">

            <div class="mb-3"><label>Nama Pemesan:</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $nama; ?>" required>
            </div>
            <div class="mb-3"><label>No HP:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone; ?>" required>
            </div>
            <div class="mb-3"><label>Tanggal Pesan:</label>
                <input type="date" id="tgl" name="tgl" class="form-control" value="<?php echo $tgl; ?>" required>
            </div>
            <div class="mb-3"><label>Waktu Wisata (Hari):</label>
                <input type="number" id="hari" name="hari" class="form-control" min="1" value="<?php echo $hari; ?>" onchange="hitungTotal()" required>
            </div>
            
            <label class="fw-bold">Pilih Layanan:</label>
            <div class="form-check">
                <input type="checkbox" id="inap" name="inap" class="form-check-input" onclick="hitungTotal()" <?php if($inap) echo "checked"; ?>>
                <label>Penginapan (Rp 1.000.000)</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="transport" name="transport" class="form-check-input" onclick="hitungTotal()" <?php if($transport) echo "checked"; ?>>
                <label>Transportasi (Rp 1.200.000)</label>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" id="makan" name="makan" class="form-check-input" onclick="hitungTotal()" <?php if($makan) echo "checked"; ?>>
                <label>Makan (Rp 500.000)</label>
            </div>

            <div class="mb-3"><label>Jumlah Peserta:</label>
                <input type="number" id="peserta" name="peserta" class="form-control" min="1" value="<?php echo $peserta; ?>" onchange="hitungTotal()" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Harga Paket (Rp):</label>
                    <input type="text" id="harga_paket" name="harga_paket" class="form-control" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-primary fw-bold">Total Tagihan (Rp):</label>
                    <input type="text" id="total_tagihan" name="total_tagihan" class="form-control fw-bold text-primary" readonly>
                </div>
            </div>

            <button type="submit" name="simpan" class="btn btn-alam w-100">Simpan Pesanan</button>
        </form>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>