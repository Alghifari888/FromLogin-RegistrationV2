<?php
// Pastikan session sudah jalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="#">MyApp</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto">

        <?php if (isset($_SESSION['role'])): ?>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="admin.php">Admin Panel</a></li>
          <?php elseif ($_SESSION['role'] === 'member'): ?>
            <li class="nav-item"><a class="nav-link" href="member.php">Member Area</a></li>
          <?php elseif ($_SESSION['role'] === 'user'): ?>
            <li class="nav-item"><a class="nav-link" href="user.php">User Dashboard</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="../index.php">Login</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
