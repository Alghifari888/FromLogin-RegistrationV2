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
<body>

<?php include '../navbar.php'; ?>

<!-- Konten User -->
<h1 class="text-center">User</h1>

<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
