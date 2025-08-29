<?php
session_start();
// Hanya bisa diakses setelah checkout
// Tidak perlu validasi session karena ini halaman akhir
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - WarungSaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thank-you-card {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="thank-you-card">
        <div class="card shadow">
            <div class="card-body">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                <h2 class="mt-3">Terima Kasih!</h2>
                <p>Pesanan Anda telah berhasil diterima.</p>
                <p>Kami akan segera menghubungi Anda untuk konfirmasi dan pengiriman.</p>
                <a href="index.php" class="btn btn-primary">Lanjut Belanja</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>