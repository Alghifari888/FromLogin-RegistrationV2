<?php
// Menghubungkan ke file konfigurasi database
require 'config/database.php';

// Menghubungkan ke file session untuk memulai/melanjutkan session PHP
require 'includes/session.php';

require 'includes/functions.php';

// Inisialisasi variabel error login
$loginError = '';

// Mengecek apakah request berasal dari form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil nilai email dan password dari input user
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ambil data user + role
    $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan ke session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        switch ($user['role']) {
            case 'admin':
                header("Location: public/admin.php");
                break;
            case 'member':
                header("Location: public/member.php");
                break;
            default:
                header("Location: public/user.php");
        }
        exit;
    } else {
        $loginError = 'Email atau password salah!';
    }
}
?>


<!-- Mulai tampilan HTML -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"> <!-- Encoding karakter -->
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Supaya responsif di mobile -->
  <title>Login</title>
  <!-- Memuat file CSS Bootstrap dari folder lokal -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <!-- Card login -->
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title text-center mb-4">Login</h4>

            <!-- Tampilkan pesan error jika ada -->
            <?php if ($loginError): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
            <?php endif; ?>

            <!-- Form login -->
            <form method="POST">
              <!-- Input Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Masukkan email">
              </div>

              <!-- Input Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password">
              </div>

              <!-- Tombol Submit -->
              <button type="submit" class="btn btn-success w-100">Login</button>
            </form>

            <!-- Link ke halaman register -->
            <div class="text-center mt-3">
              <a href="public/register.php">Belum punya akun? Daftar di sini</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- File JavaScript Bootstrap (opsional, untuk komponen interaktif) -->
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
