<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Cek apakah input kosong
    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi.";
    } else {
        try {
            // Cari admin berdasarkan username
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            // Jika admin ditemukan dan password cocok
            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Username atau password salah.";
            }
        } catch (Exception $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - WarungSaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .login-box { max-width: 400px; margin: 100px auto; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h4>🔐 Login Admin</h4>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <p class="text-center mt-3">
        <small>Default: admin / admin123</small>
    </p>
</div>
</body>
</html>