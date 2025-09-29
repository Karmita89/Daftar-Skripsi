<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($nim) && !empty($password)) {
        $stmt = $koneksi->prepare("SELECT * FROM mahasiswa_login WHERE NIM = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Periksa password
            if (password_verify($password, $user['password'])) {
                $_SESSION['nim'] = $user['NIM'];
                header("Location: profil.html");
                exit;
            } else {
                $_SESSION['error'] = "Kata sandi salah.";
            }
        } else {
            $_SESSION['error'] = "NIM tidak ditemukan.";
        }
    } else {
        $_SESSION['error'] = "Harap isi NIM dan kata sandi.";
    }

    header("Location: index.php");
    exit;
}
?>
