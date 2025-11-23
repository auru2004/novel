<?php
// Tambah rak
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk menambah rak

$page_title = "Tambah Rak";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $name = sanitize_input($_POST['name']);
    $location = sanitize_input($_POST['location']);
    $description = sanitize_input($_POST['description']);
    
    try {
        // Insert ke database
        $stmt = $pdo->prepare("INSERT INTO racks (name, location, description, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$name, $location, $description]);
        
        echo "<div class='alert alert-success'>Rak berhasil ditambahkan!</div>";
        echo "<a href='index.php'>Kembali ke Daftar Rak</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal menambahkan rak: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<h2>Tambah Rak Buku Baru</h2>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Nama Rak:</label>";
    echo "<input type='text' id='name' name='name' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='location'>Lokasi:</label>";
    echo "<input type='text' id='location' name='location'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='description'>Deskripsi:</label>";
    echo "<textarea id='description' name='description'></textarea>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Simpan Rak' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>