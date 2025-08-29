<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit;
}
require '../includes/db.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM produk ORDER BY nama");
$produk = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="col-md-10">
    <h2>Daftar Produk</h2>
    <a href="tambah.php" class="btn btn-success mb-3">+ Tambah Produk</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td><?= $p['stok'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>