
<?php
session_start();

// Set timeout (dalam detik)
$timeout = 900; // 15 menit

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();     // hapus semua data
    session_destroy();   // destroy session
    header("Location: ../index.php?timeout=1");
    exit;
}

$_SESSION['LAST_ACTIVITY'] = time(); // perbarui waktu terakhir aktif

?>
