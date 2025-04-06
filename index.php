<?php
// Menghubungkan ke file konfigurasi database
require 'config/database.php';

// Menghubungkan ke file session untuk memulai/melanjutkan session PHP
require 'includes/session.php';

// Inisialisasi variabel error login
$loginError = '';

// Mengecek apakah request berasal dari form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil nilai email dari input user
    $email = $_POST['email'];
    // Mengambil nilai password dari input user
    $password = $_POST['password'];

    // Mempersiapkan statement SQL untuk mencari user berdasarkan email
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]); // Menjalankan query dengan email sebagai parameter
    $user = $stmt->fetch(); // Mengambil hasil query (jika ada)

    // Jika user ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        // Simpan ID user ke session untuk login
        $_SESSION['user_id'] = $user['id'];

        // Redirect ke dashboard
        header("Location: public/dashboard.php");
        exit;
    } else {
        // Jika gagal login, tampilkan pesan error
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
