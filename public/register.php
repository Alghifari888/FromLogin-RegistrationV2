<?php
require '../includes/session.php'; // Untuk session_start() dan timeout
require '../config/database.php';

$registerError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registerError = 'Email tidak valid.';
    } elseif (strlen($password) < 8) {
        $registerError = 'Password minimal 8 karakter.';
    } else {
        // Cek apakah email sudah terdaftar
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $registerError = 'Email sudah terdaftar.';
        } else {
            // Simpan user baru
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashed, 'user']);

            // Ambil ID terakhir yang dimasukkan
            $userId = $pdo->lastInsertId();

            // Simpan ke session untuk auto-login
            $_SESSION['user_id'] = $userId;
            $_SESSION['role'] = 'user';

            // Redirect ke dashboard user
            header("Location: public/user/user.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../style/register.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow d-flex flex-row">

          <!-- Gambar di sisi kiri -->
          <div class="col-md-6 register-image d-none d-md-block"></div>

          <!-- Form register di sisi kanan -->
          <div class="col-md-6 p-4">
            <h4 class="text-center mb-4">Register</h4>

            <?php if ($registerError): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($registerError) ?></div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Masukkan email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 8 karakter">
              </div>
              <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>

            <div class="text-center mt-3">
              <a href="../index.php">Sudah punya akun? Login di sini</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>