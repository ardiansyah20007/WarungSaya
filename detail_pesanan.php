<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID pesanan tidak valid.");
}

// Ambil data pesanan
$stmt = $pdo->prepare("SELECT * FROM pesanan WHERE id = ?");
$stmt->execute([$id]);
$pesanan = $stmt->fetch();

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}

// Ambil detail pesanan
$stmt = $pdo->prepare("
    SELECT dp.*, p.nama 
    FROM detail_pesanan dp
    JOIN produk p ON dp.produk_id = p.id
    WHERE dp.pesanan_id = ?
");
$stmt->execute([$id]);
$detail = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="col-md-10">
    <h2>Detail Pesanan #<?= $pesanan['id'] ?></h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nama:</strong> <?= $pesanan['nama_pelanggan'] ?></p>
            <p><strong>No HP:</strong> <?= $pesanan['no_hp'] ?></p>
            <p><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($pesanan['alamat'])) ?></p>
            <p><strong>Metode Bayar:</strong> <?= $pesanan['metode_bayar'] ?></p>
            <p><strong>Total:</strong> Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></p>
            <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($pesanan['tanggal'])) ?></p>
        </div>
    </div>

    <h5>Produk yang Dibeli</h5>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $d): 
                $subtotal = $d['jumlah'] * $d['harga_satuan'];
            ?>
                <tr>
                    <td><?= $d['nama'] ?></td>
                    <td>Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?></td>
                    <td><?= $d['jumlah'] ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>

<?php include '../includes/footer.php'; ?>