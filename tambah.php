<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit;
}
require '../includes/db.php';

$error = '';
$success = '';

if ($_POST) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    // Cek validasi
    if (empty($nama) || !is_numeric($harga) || !is_numeric($stok)) {
        $error = "Data tidak valid.";
    } else {
        // Handle upload gambar
        $gambar = 'default.jpg'; // Default jika tidak upload
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            $file_type = $_FILES['gambar']['type'];

            if (!in_array($file_type, $allowed_types)) {
                $error = "Format gambar tidak didukung (harus JPG/PNG).";
            } else {
                $file_name = uniqid() . '_' . basename($_FILES['gambar']['name']);
                $upload_dir = '../assets/images/';
                $target_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_path)) {
                    $gambar = $file_name;
                } else {
                    $error = "Gagal mengunggah gambar.";
                }
            }
        }

        if (!$error) {
            $stmt = $pdo->prepare("INSERT INTO produk (nama, harga, stok, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $harga, $stok, $deskripsi, $gambar]);
            $success = "Produk berhasil ditambahkan!";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>

<div class="col-md-10">
    <h2>Tambah Produk Baru</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Produk</label>
            <input type="file" name="gambar" accept="image/*" class="form-control">
            <small class="text-muted">JPG atau PNG maksimal 2MB</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>