<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit;
}
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    header('Location: index.php');
    exit;
}

if ($_POST) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    if (empty($nama) || !is_numeric($harga) || !is_numeric($stok)) {
        $error = "Data tidak valid.";
    } else {
        // Handle upload gambar
        $gambar = $produk['gambar']; // Jaga agar tetap sama jika tidak upload
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            $file_type = $_FILES['gambar']['type'];

            if (!in_array($file_type, $allowed_types)) {
                $error = "Format gambar tidak didukung.";
            } else {
                $file_name = uniqid() . '_' . basename($_FILES['gambar']['name']);
                $upload_dir = '../assets/images/';
                $target_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_path)) {
                    // Hapus gambar lama jika ada
                    if ($produk['gambar'] !== 'default.jpg') {
                        unlink('../assets/images/' . $produk['gambar']);
                    }
                    $gambar = $file_name;
                } else {
                    $error = "Gagal mengunggah gambar.";
                }
            }
        }

        if (!$error) {
            $stmt = $pdo->prepare("UPDATE produk SET nama = ?, harga = ?, stok = ?, deskripsi = ?, gambar = ? WHERE id = ?");
            $stmt->execute([$nama, $harga, $stok, $deskripsi, $gambar, $id]);
            header('Location: index.php');
            exit;
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="col-md-10">
    <h2>Edit Produk</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($produk['nama']) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="<?= $produk['harga'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $produk['stok'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Produk</label>
            <input type="file" name="gambar" accept="image/*" class="form-control">
            <?php if ($produk['gambar'] && $produk['gambar'] !== 'default.jpg'): ?>
                <img src="../assets/images/<?= $produk['gambar'] ?>" style="max-width: 150px; margin-top: 10px;" alt="Preview">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>