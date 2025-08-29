<?php
echo "<h3>Hash untuk password: <strong>admin123</strong></h3>";
echo "<pre>";
echo password_hash('admin123', PASSWORD_DEFAULT);
echo "</pre>";
?>