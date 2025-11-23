<?php
// Edit rak
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk mengedit rak

$page_title = "Edit Rak";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$rack_id = (int)$_GET['id'];

// Ambil data rak
$stmt = $pdo->prepare("SELECT * FROM racks WHERE id = ?");
$stmt->execute([$rack_id]);
$rack = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rack) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $name = sanitize_input($_POST['name']);
    $location = sanitize_input($_POST['location']);
    $description = sanitize_input($_POST['description']);
    
    try {
        // Update database
        $stmt = $pdo->prepare("UPDATE racks SET name=?, location=?, description=? WHERE id=?");
        $stmt->execute([$name, $location, $description, $rack_id]);
        
        echo "<div class='alert alert-success'>Rak berhasil diperbarui!</div>";
        echo "<a href='index.php'>Kembali ke Daftar Rak</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal memperbarui rak: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<h2>Edit Rak: " . $rack['name'] . "</h2>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Nama Rak:</label>";
    echo "<input type='text' id='name' name='name' value='" . htmlspecialchars($rack['name']) . "' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='location'>Lokasi:</label>";
    echo "<input type='text' id='location' name='location' value='" . htmlspecialchars($rack['location'] ?? '') . "'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='description'>Deskripsi:</label>";
    echo "<textarea id='description' name='description'>" . htmlspecialchars($rack['description']) . "</textarea>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Perbarui Rak' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>