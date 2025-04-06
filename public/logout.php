<?php
require '../includes/session.php'; // Memastikan session sudah dimulai

// Hapus semua data session
$_SESSION = []; // Kosongkan array session

// Hapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session di server
session_destroy();

// Redirect ke halaman login (index)
header("Location: ../index.php");
exit;
