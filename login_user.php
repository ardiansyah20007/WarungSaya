<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - WarungSaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-dark text-white d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card p-4 shadow" style="min-width:350px;">
    <h3 class="mb-3 text-center">Login</h3>

    <!-- Alert kalau password/email salah -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>

    <!-- Alert kalau register berhasil -->
    <?php elseif (isset($_GET['registered'])): ?>
        <div class="alert alert-success">Registrasi berhasil, silakan login!</div>

    <!-- Alert kalau dipaksa login dulu (misal dari keranjang) -->
    <?php elseif (isset($_GET['need_login'])): ?>
        <div class="alert alert-warning">
            Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Email / No. Telp</label>
            <input type="text" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Masuk</button>
        <p class="mt-3">Belum punya akun? <a href="register_user.php">Register</a></p>
        <a href="index.php" class="btn btn-secondary mt-2 w-100">← Kembali</a>
    </form>
</div>

</body>
</html>
