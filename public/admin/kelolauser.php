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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
    <form method="POST" class="row g-2 mb-4">
        <input type="hidden" name="action" value="tambah">
        <div class="col-md-3"><input name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-2"><input name="password" class="form-control" placeholder="Password" required></div>
        <div class="col-md-2">
            <select name="role" class="form-select" required>
                <option value="user">user</option>
                <option value="member">member</option>
                <option value="admin">admin</option>
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-success">Tambah</button></div>
    </form>

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
