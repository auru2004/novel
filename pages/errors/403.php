<?php
// Access denied
require_once '../../config.php';
require_once '../../includes/header.php';

$page_title = "Akses Ditolak";

echo "<h2>Akses Ditolak</h2>";
echo "<p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>";
echo "<a href='../../index.php'>Kembali ke Beranda</a>";

require_once '../../includes/footer.php';
?>