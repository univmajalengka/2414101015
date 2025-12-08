A. Codingan form-daftar.php

1. Error 1 – DOCTYPE tidak valid
Pesan Error: Tidak muncul di browser, tetapi menyebabkan struktur HTML tidak standar.
Jenis: Syntax error (HTML)
Letak: Baris pertama
Kode Salah:
<DOCTYPE >
Penyebab: Tag DOCTYPE salah penulisan.
Perbaikan:
<!DOCTYPE html>

2. Error 2 – Tidak ada validasi input
   Pesan Error: Tidak muncul. Tetapi form bisa submit meski data kosong.
   Jenis: Logic error / UX issue
   Letak: Semua input form
   Perbaikan: Menambahkan atribut required pada input dan textarea.

B. Codingan proses-pendaftaran-2.php

1. Error 1 – Variabel tidak memakai tanda dolar
   Kode yang salah:
   sekolah = $_POST['sekolah_asal'];
Jenis Error: Syntax error / Undefined variable
Penyebab: Variabel PHP harus selalu menggunakan tanda $.
Cara memperbaiki:
$sekolah = $\_POST['sekolah_asal'];

2. Error 2 – Keyword SQL salah: VALUE
   Kode yang salah:
   VALUE ('$nama', '$alamat', '$jk', '$agama', '$sekolah')
Jenis Error: SQL syntax error
Penyebab: SQL yang benar adalah VALUES, bukan VALUE.
Cara memperbaiki:
VALUES ('$nama', '$alamat', '$jk', '$agama', '$sekolah')
