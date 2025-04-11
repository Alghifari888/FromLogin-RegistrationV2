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
<body>

<?php include '../navbar.php'; ?>

<!-- Konten User -->
<h1 class="text-center">Member</h1>

<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
