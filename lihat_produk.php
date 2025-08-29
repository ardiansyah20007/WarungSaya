<?php
session_start();
require 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    header("Location: index.php?error=notfound");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produk['nama']) ?> - WarungSaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container mt-4 mb-5">
    <div class="row justify-content-start"> <!-- Geser ke kiri -->
        <div class="col-12 col-md-10 col-lg-9"> <!-- Lebih lebar, tapi tidak penuh -->
            <div class="product-detail">
                <div class="row g-4">
                    <!-- Gambar (kiri) -->
                    <div class="col-12 col-md-6">
                        <img src="assets/images/<?= htmlspecialchars($produk['gambar']) ?>" 
                             alt="<?= htmlspecialchars($produk['nama']) ?>"
                             class="img-fluid rounded shadow-sm">
                    </div>

                    <!-- Info Produk (kanan) -->
                    <div class="col-12 col-md-6">
                        <h2 class="product-info"><?= htmlspecialchars($produk['nama']) ?></h2>
                        <p class="price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                        <p class="stock">Stok: <?= $produk['stok'] ?></p>
                        <p class="desc"><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>

                        <div class="d-flex gap-2 mt-3">
                            <a href="index.php" class="btn btn-back">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="index.php?add_to_cart=<?= $produk['id'] ?>" class="btn btn-add">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>