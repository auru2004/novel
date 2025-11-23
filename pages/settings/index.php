<?php
// Pengaturan aplikasi
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_admin(); // Harus admin untuk mengakses pengaturan

$page_title = "Pengaturan Aplikasi";

echo "<h2>Pengaturan Aplikasi</h2>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses simpan pengaturan
    echo "<div class='alert alert-success'>Pengaturan berhasil disimpan!</div>";
} else {
    echo "<p>Halaman untuk mengelola pengaturan aplikasi.</p>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='app_name'>Nama Aplikasi:</label>";
    echo "<input type='text' id='app_name' name='app_name' value='" . SITE_NAME . "'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='max_borrow_days'>Maksimal Hari Peminjaman:</label>";
    echo "<input type='number' id='max_borrow_days' name='max_borrow_days' value='7'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='max_books_per_user'>Maksimal Buku per Pengguna:</label>";
    echo "<input type='number' id='max_books_per_user' name='max_books_per_user' value='5'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Simpan Pengaturan' class='btn btn-primary'>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>