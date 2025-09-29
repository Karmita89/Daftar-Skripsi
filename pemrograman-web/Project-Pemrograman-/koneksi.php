<?php
$host = "db"; // gunakan "db" jika pakai Docker (lihat docker-compose), atau "localhost" jika tidak
$user = "admin";
$pass = "admin123";
$db   = "skripsi";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
