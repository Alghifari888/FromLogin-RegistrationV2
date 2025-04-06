
<?php
require '../includes/session.php';
require '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: index.php");
    exit;
}
?>
<h1>Selamat datang di Dashboard!</h1>
<p><a href="logout.php">Logout</a></p>
