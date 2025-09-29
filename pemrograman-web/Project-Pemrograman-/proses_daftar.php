<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

$nama_lengkap = $_POST['nama'] ?? '';
$nim = $_POST['nim'] ?? '';
$judul_skripsi = $_POST['judul'] ?? '';
$pembimbing = $_POST['pembimbing'] ?? '';

if ($nama_lengkap && $nim && $judul_skripsi && $pembimbing) {
    $sql = "INSERT INTO pendaftaran_skripsi (nama_lengkap, nim, judul_skripsi, pembimbing)
            VALUES ('$nama_lengkap', '$nim', '$judul_skripsi', '$pembimbing')";

    if ($koneksi->query($sql) === TRUE) {
        echo "Pendaftaran berhasil disimpan!";
    } else {
        echo "Gagal menyimpan data: " . $koneksi->error;
    }
} else {
    echo "Semua field harus diisi.";
}

$koneksi->close();
?>
