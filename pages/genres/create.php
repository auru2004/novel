<?php
// Tambah genre
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk menambah genre

$page_title = "Tambah Genre";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    
    try {
        // Insert ke database
        $stmt = $pdo->prepare("INSERT INTO genres (name, description, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$name, $description]);
        
        echo "<div class='alert alert-success'>Genre berhasil ditambahkan!</div>";
        echo "<a href='index.php'>Kembali ke Daftar Genre</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal menambahkan genre: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<h2>Tambah Genre Baru</h2>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Nama Genre:</label>";
    echo "<input type='text' id='name' name='name' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='description'>Deskripsi:</label>";
    echo "<textarea id='description' name='description'></textarea>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Simpan Genre' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>