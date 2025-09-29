<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php';

$nim = isset($_GET['nim']) ? $_GET['nim'] : '';
$data = null;

if ($nim) {
    $stmt = $koneksi->prepare("SELECT * FROM pendaftaran_skripsi WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Status Pengajuan Skripsi | FTI UNMER</title>
  <link rel="icon" href="assets/images/logo/fti.png" type="image/png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f7f9;
      font-family: Arial, sans-serif;
      padding-top: 40px;
    }
    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .logo {
      display: block;
      margin: 0 auto 20px;
      max-width: 100px;
    }
    h2, h4 {
      text-align: center;
      color: #003366;
    }
    .subtitle {
      text-align: center;
      color: #666;
      margin-bottom: 30px;
    }
    .note {
      margin-top: 25px;
      font-size: 0.9rem;
      color: #777;
    }
    .btn-print {
      margin-bottom: 20px;
    }

    @media print {
      .btn, .note, .btn-print {
        display: none;
      }
    }

    .ttd {
      margin-top: 60px;
      text-align: right;
    }

    .ttd .nama {
      margin-top: 80px;
      font-weight: bold;
      text-decoration: underline;
    }

    .ttd .nip {
      margin-top: -5px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="assets/images/logo/fti.png" alt="Logo FTI" class="logo">

    <?php if (!$nim): ?>
      <h2>Status Pengajuan Skripsi</h2>
      <p class="subtitle">Fakultas Teknologi Informasi - Universitas Merdeka Malang</p>
      <form action="status.php" method="get">
        <div class="form-group">
          <label for="nim">Masukkan NIM Anda:</label>
          <input type="text" name="nim" id="nim" class="form-control" placeholder="Contoh: 2141720123" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Cek Status</button>
      </form>
      <p class="note">* Masukkan NIM Anda untuk melihat status pengajuan skripsi pribadi.</p>

    <?php elseif ($data): ?>
      <button class="btn btn-success btn-print" onclick="window.print();"><i class="fas fa-print"></i> Cetak Halaman</button>
      <h4>Detail Pengajuan Skripsi</h4>
      <table class="table table-bordered mt-4">
        <tr>
          <th>NIM</th>
          <td><?php echo htmlspecialchars($data['nim']); ?></td>
        </tr>
        <tr>
          <th>Nama</th>
          <td><?php echo htmlspecialchars($data['nama_lengkap']); ?></td>
        </tr>
        <tr>
          <th>Judul Skripsi</th>
          <td><?php echo htmlspecialchars($data['judul_skripsi']); ?></td>
        </tr>
        <tr>
          <th>Status</th>
          <td><?php echo htmlspecialchars($data['status']); ?></td>
        </tr>
        <?php if ($data['status'] === 'Diterima' && !empty($data['tanggal_sidang'])): ?>
        <tr>
          <th>Tanggal Sidang</th>
          <td><?php echo date('d-m-Y', strtotime($data['tanggal_sidang'])); ?></td>
        </tr>
        <?php endif; ?>
      </table>

      <!-- Tambahan Kolom Tanda Tangan -->
      <div class="ttd">
        <p>Mengetahui,</p>
        <p>Dekan Fakultas Teknologi Informasi</p>
        <p class="nama">Dr. Ir. Deka Nata, S.T., M.T.</p>
        <p class="nip">NIP. 19651101 199001 1 001</p>
      </div>

      <a href="status.php" class="btn btn-secondary mt-4">Cek NIM Lain</a>

    <?php else: ?>
      <div class="alert alert-warning">Data tidak ditemukan untuk NIM <strong><?php echo htmlspecialchars($nim); ?></strong>.</div>
      <a href="status.php" class="btn btn-secondary">Coba Lagi</a>
    <?php endif; ?>
  </div>

  <!-- Font Awesome (untuk ikon printer) -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
