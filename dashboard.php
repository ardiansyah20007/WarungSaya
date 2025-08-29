<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require '../includes/db.php';

// Hitung data produk
$stmt = $pdo->query("SELECT COUNT(*) FROM produk");
$jumlah_produk = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT SUM(harga * stok) FROM produk");
$total_stok = $stmt->fetchColumn();

// Hitung pesanan
$stmt = $pdo->query("SELECT COUNT(*) FROM pesanan");
$jumlah_pesanan = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM pesanan WHERE DATE(tanggal) = CURDATE()");
$pesanan_hari_ini = $stmt->fetchColumn();

// Ambil 5 pesanan terbaru
$stmt = $pdo->prepare("
    SELECT id, nama_pelanggan, no_hp, total, tanggal 
    FROM pesanan 
    ORDER BY tanggal DESC 
    LIMIT 5
");
$stmt->execute();
$pesanan_terbaru = $stmt->fetchAll();

// Hitung total pendapatan
$stmt = $pdo->query("SELECT COALESCE(SUM(total), 0) FROM pesanan");
$total_pendapatan = $stmt->fetchColumn();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="col-md-10">
    <h2>Dashboard Admin</h2>

    <!-- Ringkasan -->
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Jumlah Produk</h5>
                    <h2><?= $jumlah_produk ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Pesanan Hari Ini</h5>
                    <h2><?= $pesanan_hari_ini ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5>Total Pesanan</h5>
                    <h2><?= $jumlah_pesanan ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>Total Pendapatan</h5>
                    <h2>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pesanan Terbaru -->
    <h4 class="mt-4">Pesanan Terbaru</h4>
<table class="table table-bordered table-striped mt-3">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>No HP</th>
            <th>Total</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($pesanan_terbaru)): ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada pesanan.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($pesanan_terbaru as $p): ?>
                <tr>
                    <td>#<?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($p['no_hp']) ?></td>
                    <td>Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($p['tanggal'])) ?></td>
                    <td>
                        <a href="detail_pesanan.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>

<?php include '../includes/footer.php'; ?>