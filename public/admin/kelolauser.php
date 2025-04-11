<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../includes/session.php';
require '../../includes/functions.php';
require '../../config/database.php'; // koneksi ke DB


if (!isLoggedIn() || !isAdmin()) {
    header("Location: ../../index.php");
    exit;
}

$errors = [];
$success = "";

// Tambah user
if (isset($_POST['action']) && $_POST['action'] === 'tambah') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password minimal 8 karakter.";
    } else {
        $cek = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $cek->execute([$email]);
        if ($cek->fetch()) {
            $errors[] = "Email sudah terdaftar.";
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashed, $role]);
            $success = "User berhasil ditambahkan.";
        }
    }
}

// Edit user
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    } else {
        $sql = "UPDATE users SET email = ?, role = ?";
        $params = [$email, $role];

        if (!empty($password)) {
            if (strlen($password) < 8) {
                $errors[] = "Password minimal 8 karakter.";
            } else {
                $sql .= ", password = ?";
                $params[] = password_hash($password, PASSWORD_BCRYPT);
            }
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        if (!$errors) {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $success = "User berhasil diupdate.";
        }
    }
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    $success = "User berhasil dihapus.";
}

// Ambil semua data user
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll();

// Filter
$filterEmail = $_GET['filter_email'] ?? '';
$filterRole = $_GET['filter_role'] ?? '';

// Ambil user dengan filter
$query = "SELECT * FROM users WHERE 1";
$params = [];

if (!empty($filterEmail)) {
    $query .= " AND email LIKE ?";
    $params[] = "%$filterEmail%";
}

if (!empty($filterRole)) {
    $query .= " AND role = ?";
    $params[] = $filterRole;
}

$query .= " ORDER BY id ASC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../style/navbar.css" rel="stylesheet">
    <link href="../../style/kelolauser.css" rel="stylesheet">

</head>
<body>
<?php include '../navbar.php'; ?>


<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Panel - Kelola Pengguna</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

<!-- Form Tambah -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <h6 class="text-center mb-3 fw-semibold">Tambah Pengguna Baru</h6>
    <form method="POST" class="row g-2 align-items-center">
        <input type="hidden" name="action" value="tambah">
        <div class="col-lg-4 col-md-6">
            <input name="email" class="form-control form-control-sm" placeholder="Email" required>
        </div>
        <div class="col-lg-3 col-md-6">
            <input name="password" class="form-control form-control-sm" placeholder="Password" required>
        </div>
        <div class="col-lg-2 col-md-4">
            <select name="role" class="form-select form-select-sm" required>
                <option value="user">user</option>
                <option value="member">member</option>
                <option value="admin">admin</option>
            </select>
        </div>
        <div class="col-lg-3 col-md-4 d-grid">
            <button class="btn btn-success btn-sm">Tambah</button>
        </div>
    </form>
</div>

<!-- Form Filter -->
<div class="card border-0 shadow-sm p-3 mb-4">
    <form method="GET" class="row g-2 align-items-center">
        <div class="col-lg-5 col-md-6">
            <input type="text" name="filter_email" class="form-control form-control-sm" placeholder="Cari berdasarkan email"
                   value="<?= htmlspecialchars($filterEmail) ?>">
        </div>
        <div class="col-lg-3 col-md-4">
            <select name="filter_role" class="form-select form-select-sm">
                <option value="">Semua Role</option>
                <option value="user" <?= $filterRole === 'user' ? 'selected' : '' ?>>user</option>
                <option value="member" <?= $filterRole === 'member' ? 'selected' : '' ?>>member</option>
                <option value="admin" <?= $filterRole === 'admin' ? 'selected' : '' ?>>admin</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-3 d-grid">
            <button class="btn btn-primary btn-sm">Filter</button>
        </div>
        <div class="col-lg-2 col-md-3 d-grid">
            <a href="kelolauser.php" class="btn btn-secondary btn-sm">Reset</a>
        </div>
    </form>
</div>


    <!-- Tabel User -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Password (Baru)</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <form method="POST">
                <tr>
                    <td>
                        <?= $u['id'] ?>
                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    </td>
                    <td><input name="email" value="<?= htmlspecialchars($u['email']) ?>" class="form-control" required></td>
                    <td><input name="password" placeholder="(kosongkan jika tidak ubah)" class="form-control"></td>
                    <td>
                        <select name="role" class="form-select">
                            <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>user</option>
                            <option value="member" <?= $u['role'] === 'member' ? 'selected' : '' ?>>member</option>
                            <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                        </select>
                    </td>
                    <td><?= $u['created_at'] ?></td>
                    <td>
                        <input type="hidden" name="action" value="edit">
                        <button class="btn btn-warning btn-sm">Simpan</button>
                        <a href="?hapus=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
