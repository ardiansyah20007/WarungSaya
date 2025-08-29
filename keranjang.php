<?php
// 1. Mulai session
session_start();

// 2. Cek apakah file db.php ada di lokasi yang benar
if (!file_exists('includes/db.php')) {
    die("Error: File includes/db.php tidak ditemukan. Pastikan struktur folder benar.");
}

// 3. Sertakan koneksi database
require 'includes/db.php';

// 4. Inisialisasi keranjang jika belum ada
if (empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 5. Update jumlah produk di keranjang
if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $id = (int)$id;
        $qty = (int)$qty;

        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }
    header('Location: keranjang.php?updated=1');
    exit;
}

// 6. Hitung total harga
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['harga'] * $item['qty'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - WarungSaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">← Kembali ke Toko</a>
    </div>
</nav>

<!-- Konten Utama -->
<div class="container my-5">
    <h2 class="text-center mb-4"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>

    <!-- Alert -->
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success text-center">Keranjang berhasil diperbarui!</div>
    <?php endif; ?>

    <!-- Cek apakah keranjang kosong -->
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info text-center">
            <p>Keranjang Anda masih kosong.</p>
            <a href="index.php" class="btn btn-primary">Lanjutkan Belanja</a>
        </div>
    <?php else: ?>
        <form method="POST">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item):
                            $subtotal = $item['harga'] * $item['qty'];
                        ?>
                            <tr>
                                <td class="align-middle">
                                    <?= htmlspecialchars($item['nama']) ?>
                                </td>
                                <td class="align-middle">
                                    Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                </td>
                                <td class="align-middle">
                                    <input type="number" 
                                           name="qty[<?= $id ?>]" 
                                           value="<?= $item['qty'] ?>" 
                                           min="1" 
                                           class="form-control form-control-sm" 
                                           style="width: 70px;">
                                </td>
                                <td class="align-middle">
                                    Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                </td>
                                <td class="align-middle">
                                    <a href="hapus_dari_keranjang.php?id=<?= $id ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Hapus produk ini dari keranjang?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-light fw-bold">
                            <td colspan="3" class="text-end">Total:</td>
                            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 justify-content-center mt-3">
                <button type="submit" name="update" class="btn btn-warning">
                    <i class="fas fa-sync"></i> Perbarui Keranjang
                </button>
                <a href="checkout.php" class="btn btn-success">
                    <i class="fas fa-check"></i> Checkout
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <div class="container">&copy; 2025 WarungSaya - Tugas Akhir</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>