
<?php
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isMember() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'member';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}

?>
