<?php
require '../../includes/session.php';
require '../../includes/functions.php';

if (!isLoggedIn() || !isUser()) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>User</title>
  <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../style/navbar.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
   <?php include '../navbar.php'; ?>


   <div class="container my-4">
        <!-- Konten utama User -->
        <h1 class="text-center">User</h1>
    </div>
    <?php include '../footer.php'; ?>

<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
