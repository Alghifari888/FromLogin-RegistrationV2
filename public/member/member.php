<?php
require '../../includes/session.php';
require '../../includes/functions.php';

if (!isLoggedIn() || !isMember()) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Member</title>
  <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../style/navbar.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include '../navbar.php'; ?>

    <div class="container my-4">
        <!-- Konten utama Member-->
        <h1 class="text-center">Member</h1>
    </div>

    <?php include '../footer.php'; ?>



<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
