<?php
// Pastikan session sudah jalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config buat dapet BASE_URL
// Pastikan session aktif dan fungsi tersedia
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/config.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm custom-navbar mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold text-uppercase" href="#">alghifari888</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto align-items-center gap-2">

        <?php if (isset($_SESSION['role'])): ?>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/adminDasboard.php">Home Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/kelolauser.php">Kelola User</a></li>
          <?php elseif ($_SESSION['role'] === 'member'): ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>member/member.php">Member Area</a></li>
          <?php elseif ($_SESSION['role'] === 'user'): ?>
            <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>user/user.php">User Area</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link logout-link" href="<?= BASE_URL ?>logout.php">Logout</a></li>

        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>../index.php">Login</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
