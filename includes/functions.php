<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function isAdmin() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
}

function isMember() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'member';
}

function isUser() {
    return isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'user';
}
?>
