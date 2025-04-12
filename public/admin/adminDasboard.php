<?php
require '../../includes/session.php';
require '../../includes/functions.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin</title>
  <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../style/navbar.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
<?php include '../navbar.php'; ?>

    <div class="container my-4">
        <!-- Konten utama Admin -->
        <h1 class="text-center">Halo, Admin!</h1>
    </div>

    <?php include '../footer.php'; ?>



<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
