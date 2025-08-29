<?php
session_start();
$_SESSION['test'] = 'Session berjalan';
echo "Session aktif. Cek di browser: F12 → Application → Cookies → PHPSESSID";
?>