<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    
    $id_pesanan = $_POST['id_pesanan']; 
    $nama = $_POST['nama'];
    $phone = $_POST['phone'];
    $tgl = $_POST['tgl'];
    $hari = $_POST['hari'];
    $peserta = $_POST['peserta'];
    
    $inap = isset($_POST['inap']) ? 1 : 0;
    $transport = isset($_POST['transport']) ? 1 : 0;
    $makan = isset($_POST['makan']) ? 1 : 0;
    
    $harga = $_POST['harga_paket'];
    $tagihan = $_POST['total_tagihan'];

    if ($id_pesanan != "") {
        $query = "UPDATE pemesanan SET 
                nama_pemesan='$nama', 
                no_hp='$phone', 
                tgl_pesan='$tgl', 
                waktu_pelaksanaan='$hari', 
                jumlah_peserta='$peserta', 
                layanan_penginapan='$inap', 
                layanan_transport='$transport', 
                layanan_makan='$makan', 
                harga_paket='$harga', 
                total_tagihan='$tagihan' 
                WHERE id_pesanan='$id_pesanan'";
        $pesan = "Data pesanan berhasil diperbarui!";
    } else {
        $query = "INSERT INTO pemesanan 
                (nama_pemesan, no_hp, tgl_pesan, waktu_pelaksanaan, jumlah_peserta, layanan_penginapan, layanan_transport, layanan_makan, harga_paket, total_tagihan) 
                VALUES ('$nama', '$phone', '$tgl', '$hari', '$peserta', '$inap', '$transport', '$makan', '$harga', '$tagihan')";
        $pesan = "Pesanan baru berhasil disimpan!";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('$pesan'); 
                window.location.href='modifikasi_pesanan.php';
            </script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }

} else {
    header("Location: pemesanan.php");
}
?>