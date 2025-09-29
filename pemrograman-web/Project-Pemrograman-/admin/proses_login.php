<?php
session_start();
include '../koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['admin_login'] = true;
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Login gagal!'); window.location='login.php';</script>";
}
?>
