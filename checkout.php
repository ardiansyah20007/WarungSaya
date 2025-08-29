<?php
session_start();
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

require 'includes/db.php';

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['harga'] * $item['qty'];
}

$error = '';

if ($_POST) {
    $nama = trim($_POST['nama']);
    $no_hp = trim($_POST['no_hp']);
    $alamat = trim($_POST['alamat']);
    $metode = $_POST['metode'];

    if (empty($nama) || empty($no_hp) || empty($alamat) || empty($metode)) {
        $error = "Semua field wajib diisi.";
    } else {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO pesanan (nama_pelanggan, no_hp, alamat, metode_bayar, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $no_hp, $alamat, $metode, $total]);
            $pesanan_id = $pdo->lastInsertId();

            foreach ($_SESSION['cart'] as $item) {
                $stmt = $pdo->prepare("INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga_satuan) VALUES (?, ?, ?, ?)");
                $stmt->execute([$pesanan_id, $item['id'], $item['qty'], $item['harga']]);

                // Kurangi stok
                $pdo->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?")->execute([$item['qty'], $item['id']]);
            }

            $pdo->commit();
            unset($_SESSION['cart']);
            header('Location: terima_kasih.php');
            exit;
        } catch (Exception $e) {
            $pdo->rollback();
            $error = "Terjadi kesalahan saat menyimpan pesanan. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - WarungSaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="keranjang.php">
            <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
        </a>
    </div>
</nav>

<!-- Main Content -->
<div class="container my-5" style="min-height: calc(100vh - 120px);">
    <h2 class="text-center mb-4"><i class="fas fa-credit-card"></i> Checkout Pesanan</h2>

    <!-- Alert Error -->
    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <!-- Ringkasan Pesanan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Ringkasan Pesanan</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= htmlspecialchars($item['nama']) ?> × <?= $item['qty'] ?></span>
                        <strong>Rp <?= number_format($item['harga'] * $item['qty'], 0, ',', '.') ?></strong>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold fs-5 text-success">
                    <span>Total</span>
                    <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                </li>
            </ul>
        </div>
    </div>

    <!-- Form Checkout -->
    <form method="POST">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label"><i class="fas fa-phone"></i> No HP</label>
                <input type="tel" name="no_hp" class="form-control" placeholder="Contoh: 081234567890" required>
            </div>
            <div class="col-12">
                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Merdeka No. 123, Kota, Kode Pos" required></textarea>
            </div>
            <div class="col-12">
                <label class="form-label"><i class="fas fa-money-check-alt"></i> Metode Pembayaran</label>
                <select name="metode" class="form-select" required>
                    <option value="" disabled selected>Pilih metode pembayaran</option>
                    <option value="Tunai">Bayar Tunai Saat Antar</option>
                    <option value="Transfer">Transfer Bank (BCA/BRI)</option>
                    <option value="OVO">OVO / DANA</option>
                    <option value="GoPay">GoPay</option>
                </select>
            </div>
        </div>

        <!-- Tombol -->
        <div class="d-flex flex-wrap gap-2 mt-4 justify-content-center">
            <button type="submit" class="btn btn-success btn-lg px-4">
                <i class="fas fa-check-circle"></i> Pesan Sekarang
            </button>
            <a href="keranjang.php" class="btn btn-secondary btn-lg px-4">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">&copy; 2025 WarungSaya - Tugas Akhir</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>