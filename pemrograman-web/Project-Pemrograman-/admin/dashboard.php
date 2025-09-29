<?php
// dashboard.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../koneksi.php';

// Ambil semua data mahasiswa
$result = $koneksi->query("SELECT * FROM pendaftaran_skripsi");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script>
    function handleStatusChange(nim) {
      const select = document.getElementById('status-' + nim);
      const status = select.value;

      if (status === 'Diterima') {
        window.location.href = 'update_status.php?nim=' + nim;
      } else {
        // Kirim lewat AJAX
        const catatan = prompt("Masukkan catatan (opsional):") || '';
        fetch('update_status.php', {
          method: 'POST',
          body: new URLSearchParams({
            nim: nim,
            status: status,
            catatan: catatan,
            tanggal_sidang: '' // kosong karena belum diperlukan
          })
        })
        .then(response => response.text())
        .then(alert)
        .catch(err => alert("Terjadi kesalahan: " + err));
      }
    }
  </script>
</head>
<body class="p-5">
  <div class="container">
    <h2>Dashboard Admin - Daftar Mahasiswa</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>NIM</th>
          <th>Judul Skripsi</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['nama_lengkap'] ?></td>
            <td><?= $row['nim'] ?></td>
            <td><?= $row['judul_skripsi'] ?></td>
            <td><?= $row['status'] ?? '-' ?></td>
            <td>
              <select id="status-<?= $row['nim'] ?>" class="form-control d-inline" style="width:auto;">
                <option value="">-- Pilih Status --</option>
                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                <option value="Ditolak">Ditolak</option>
                <option value="Diterima">Diterima</option>
              </select>
              <button class="btn btn-sm btn-primary" onclick="handleStatusChange('<?= $row['nim'] ?>')">Ubah Status</button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
