<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FTI UNMER | Login Mahasiswa</title>
  <link rel="icon" type="image/png" href="assets/images/logo/logofti.png" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('assets/images/logofti.png') no-repeat center center;
      background-size: cover;
      color: white;
      position: relative;
    }
    .overlay {
      background: rgba(0, 0, 0, 0.6);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .top-bar {
      background-color: #ffffff;
      color: #333;
      padding: 10px 0;
      text-align: center;
      font-weight: bold;
    }
    .main-content {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      padding: 50px 25px;
    }
    .login-box {
      background: rgba(255, 255, 255, 0.95);
      color: #333;
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      text-align: left;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }
    .maskot {
      position: fixed;
      bottom: 10px;
      right: 10px;
      width: 80px;
    }
    footer {
      background-color: #fff;
      color: #555;
      text-align: center;
      padding: 15px;
    }
    @media (max-width: 768px) {
      .main-content h1 { font-size: 28px; }
      .main-content h3 { font-size: 18px; }
    }
  </style>
</head>
<body>
  <div class="overlay">
    <div class="top-bar">
      Selamat Datang di Fakultas Teknologi Informasi Universitas Merdeka Malang
    </div>

    <div class="main-content">
      <img src="assets/images/logo/logofti.png" alt="FTI UNMER" style="width:200px; margin-bottom: 20px">
      <h1>FAKULTAS TEKNOLOGI INFORMASI</h1>
      <h3>UNIVERSITAS MERDEKA MALANG</h3>

      <div class="login-box mt-4">
        <h5 class="text-center mb-4">Login Mahasiswa</h5>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post">
          <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
          </div>
          <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>
      </div>
    </div>

    <img src="assets/images/logofti.png" alt="logo" class="maskot" />
    <footer>&copy; 2025 Fakultas Teknologi Informasi - Universitas Merdeka Malang</footer>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
