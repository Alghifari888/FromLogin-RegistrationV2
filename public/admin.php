<?php
require '../includes/session.php';
require '../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin</title>
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Konten admin -->
<h1 class="text-center">Halo, Admin!</h1>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
