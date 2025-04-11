<?php
require 'config/database.php';
require 'includes/session.php';
require 'includes/functions.php';

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        switch ($user['role']) {
            case 'admin':
                header("Location: public/admin/adminDasboard.php");
                break;
            case 'member':
                header("Location: public/member/member.php");
                break;
            default:
                header("Location: public/user/user.php");
        }
        exit;
    } else {
        $loginError = 'Email atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="style/index.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow d-flex flex-row">
          
          <!-- Kolom gambar (kiri) -->
          <div class="col-md-6 login-image d-none d-md-block"></div>

          <!-- Kolom form login (kanan) -->
          <div class="col-md-6 p-4">
            <h4 class="text-center mb-4">Login</h4>

            <?php if ($loginError): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Masukkan email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Masukkan password">
              </div>
              <button type="submit" class="btn btn-success w-100">Login</button>
            </form>

            <div class="text-center mt-3">
              <a href="public/register.php">Belum punya akun? Daftar di sini</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
