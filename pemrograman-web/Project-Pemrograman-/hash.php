<?php
// Daftar password mahasiswa
$passwords = [
    'henimiranda',
    'mitasung',
    'ajeng',
    'jenny',
    'elvya'
];

// Tampilkan hasil hash untuk setiap password
foreach ($passwords as $password) {
    echo "Password: $password<br>";
    echo "Hash: " . password_hash($password, PASSWORD_DEFAULT) . "<br><br>";
}
?>
