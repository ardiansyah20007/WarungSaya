<?php
require 'includes/db.php';
$stmt = $pdo->query("SELECT * FROM admin");
$admin = $stmt->fetch();
echo "<pre>";
print_r($admin);
echo "</pre>";
?>