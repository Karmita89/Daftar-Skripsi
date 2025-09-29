<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';

// Tangani POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'] ?? '';
    $status = $_POST['status'] ?? '';
    $tanggal_sidang = $_POST['tanggal_sidang'] ?? null;

    if (!$nim || !$status) {
        echo "NIM dan status harus diisi.";
        exit;
    }

    if ($status === "Diterima" && $tanggal_sidang) {
        $stmt = $koneksi->prepare("UPDATE pendaftaran_skripsi SET status = ?, tanggal_sidang = ? WHERE nim = ?");
        $stmt->bind_param("sss", $status, $tanggal_sidang, $nim);
    } else {
        $stmt = $koneksi->prepare("UPDATE pendaftaran_skripsi SET status = ?, tanggal_sidang = NULL WHERE nim = ?");
        $stmt->bind_param("ss", $status, $nim);
    }

    if ($stmt->execute()) {
        echo $status;
    } else {
        echo "Gagal memperbarui status: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();
    exit;
}

// Tangani GET (tampilkan form)
$nim = $_GET['nim'] ?? '';
if (!$nim) {
    echo "NIM tidak ditemukan.";
    exit;
}

$result = $koneksi->query("SELECT * FROM pendaftaran_skripsi WHERE nim = '$nim'");
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data mahasiswa tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Update Status Mahasiswa</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script>
    function kirimStatus(event) {
      event.preventDefault();

      const form = document.getElementById('formStatus');
      const formData = new FormData(form);

      fetch('update_status.php?nim=<?= $nim ?>', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(res => {
        alert("Status berhasil diperbarui!");
        window.location.href = 'dashboard.php';
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat memperbarui status.");
      });
    }

    function toggleTanggalSidang() {
      const status = document.querySelector('select[name="status"]').value;
      const tanggalField = document.getElementById('tanggalSidangGroup');

      if (status === 'Diterima') {
        tanggalField.style.display = 'block';
        tanggalField.querySelector('input').required = true;
      } else {
        tanggalField.style.display = 'none';
        tanggalField.querySelector('input').required = false;
      }
    }

    window.addEventListener('DOMContentLoaded', () => {
      toggleTanggalSidang();
      document.querySelector('select[name="status"]').addEventListener('change', toggleTanggalSidang);
    });
  </script>
</head>
<body class="p-5">
  <div class="container">
    <h2>Update Status Mahasiswa</h2>
    <form id="formStatus" onsubmit="kirimStatus(event)">
      <input type="hidden" name="nim" value="<?= htmlspecialchars($data['nim']) ?>">

      <div class="form-group">
        <label>Nama:</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" readonly>
      </div>

      <div class="form-group">
        <label>Judul Skripsi:</label>
        <textarea class="form-control" readonly><?= htmlspecialchars($data['judul_skripsi']) ?></textarea>
      </div>

      <div class="form-group">
        <label>Status:</label>
        <select name="status" class="form-control" required>
          <option value="">-- Pilih Status --</option>
          <option value="Menunggu Verifikasi" <?= $data['status'] === 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
          <option value="Diterima" <?= $data['status'] === 'Diterima' ? 'selected' : '' ?>>Diterima</option>
          <option value="Ditolak" <?= $data['status'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>
      </div>

      <div class="form-group" id="tanggalSidangGroup" style="<?= $data['status'] === 'Diterima' ? '' : 'display:none;' ?>">
        <label>Tanggal Sidang:</label>
        <input type="date" name="tanggal_sidang" class="form-control" value="<?= htmlspecialchars($data['tanggal_sidang'] ?? '') ?>">
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</body>
</html>
