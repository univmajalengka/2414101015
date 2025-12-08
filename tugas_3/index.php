<?php
include("koneksi.php");
$sql = "SELECT * FROM calon_siswa ORDER BY id DESC";
$query = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Pendaftaran Siswa Baru</title>
</head>

<body>

    <header>
        <h2>Pendaftaran Siswa Baru</h2>
    </header>

    <!-- Status -->
    <?php if (isset($_GET['status'])): ?>
        <p>
            <?php
            if ($_GET['status'] == 'sukses') {
                echo "Pendaftaran siswa baru <b>berhasil!</b>";
            } else {
                echo "Pendaftaran siswa baru <b>gagal!</b>";
            }
            ?>
        </p>
    <?php endif; ?>

    <h3>Data Pendaftar</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Sekolah Asal</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            while ($pendaftar = mysqli_fetch_array($query)):
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $pendaftar['nama']; ?></td>
                    <td><?php echo $pendaftar['alamat']; ?></td>
                    <td><?php echo $pendaftar['jenis_kelamin']; ?></td>
                    <td><?php echo $pendaftar['agama']; ?></td>
                    <td><?php echo $pendaftar['sekolah_asal']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>

    <a href="form-daftar.php">+ Tambah Pendaftar Baru</a>

</body>

</html>