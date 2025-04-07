<?php
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
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $registerError = 'Email sudah terdaftar.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashed, 'user']);

            header("Location: ../index.php");
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
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="card-title text-center mb-4">Register</h4>

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
