<?php
// File: ganti_password.php
// Fungsi: Reset password admin tanpa harus login

require 'includes/db.php';

// Password baru (bisa kamu ganti)
$password_baru = 'admin123'; // 👈 Ganti kalau mau password lain

// Hash password dengan cara yang benar
$hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);

try {
    // Cek dulu apakah tabel admin ada
    $stmt = $pdo->query("SELECT COUNT(*) FROM admin");
    
    // Update password untuk username 'admin'
    $stmt = $pdo->prepare("UPDATE admin SET password = ? WHERE username = 'admin'");
    $stmt->execute([$hashed_password]);

    echo "<div style='padding: 20px; margin: 20px; border: 1px solid #00c853; background-color: #e8f5e8; color: #1b5e20; border-radius: 8px; font-family: Arial; max-width: 600px; margin: 50px auto;'>";
    echo "<h3>✅ Password Berhasil Diubah!</h3>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> $password_baru</p>";
    echo "<p>Password sudah di-hash dan disimpan di database.</p>";
    echo "<a href='admin/login.php' class='btn btn-primary' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;'>➡️ Masuk ke Login</a>";
    echo "</div>";

} catch (Exception $e) {
    // Jika tabel tidak ditemukan
    if ($e->getCode() == '42S02') {
        echo "<div style='padding: 20px; margin: 20px; border: 1px solid #ff5722; background-color: #ffebee; color: #c62828; border-radius: 8px; font-family: Arial; max-width: 600px; margin: 50px auto;'>";
        echo "<h3>❌ Gagal: Tabel 'admin' tidak ditemukan!</h3>";
        echo "<p>Harap pastikan:</p>";
        echo "<ol>";
        echo "<li>Kamu sudah impor <code>database.sql</code></li>";
        echo "<li>Database <strong>warungsaya</strong> aktif</li>";
        echo "<li>Tabel <strong>admin</strong> sudah dibuat</li>";
        echo "</ol>";
        echo "<p><a href='admin/login.php'>Coba buat tabel dulu</a></p>";
        echo "</div>";
    } else {
        echo "<div style='padding: 20px; margin: 20px; border: 1px solid #ff5722; background-color: #ffebee; color: #c62828; border-radius: 8px; font-family: Arial; max-width: 600px; margin: 50px auto;'>";
        echo "<h3>❌ Error: " . $e->getMessage() . "</h3>";
        echo "</div>";
    }
}
?>