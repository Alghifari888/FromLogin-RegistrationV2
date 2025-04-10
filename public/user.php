<?php
require '../includes/session.php';
require '../includes/functions.php';

if (!isLoggedIn() || !isUser()) {
    header("Location: ../index.php");
    exit;
}
?>
<h1>Dashboard User</h1>
<p>Selamat datang User! ID Anda: <?= $_SESSION['user_id'] ?></p>
<p><a href="logout.php">Logout</a></p>
