<?php
// Hapus rak
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk menghapus rak

$page_title = "Hapus Rak";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    try {
        // Hapus dari database
        $stmt = $pdo->prepare("DELETE FROM racks WHERE id = ?");
        $stmt->execute([$rack_id]);
        
        echo "<div class='alert alert-success'>Rak berhasil dihapus!</div>";
        echo "<a href='index.php' class='btn'>Kembali ke Daftar Rak</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal menghapus rak: " . $e->getMessage() . "</div>";
        echo "<a href='index.php' class='btn'>Kembali</a>";
    }
} else {
    echo "<h2>Konfirmasi Hapus Rak</h2>";
    echo "<p>Apakah Anda yakin ingin menghapus rak berikut?</p>";
    echo "<div class='rack-preview'>";
    echo "<h3>" . $rack['name'] . "</h3>";
    echo "<p>Lokasi: " . ($rack['location'] ?? 'Tidak Diketahui') . "</p>";
    echo "<p>" . $rack['description'] . "</p>";
    echo "</div>";
    
    echo "<form method='post'>";
    echo "<input type='hidden' name='confirm' value='1'>";
    echo "<input type='submit' value='Ya, Hapus Rak Ini' class='btn btn-danger'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>