<?php
// Hapus genre
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk menghapus genre

$page_title = "Hapus Genre";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$genre_id = (int)$_GET['id'];

// Ambil data genre
$stmt = $pdo->prepare("SELECT * FROM genres WHERE id = ?");
$stmt->execute([$genre_id]);
$genre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$genre) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    try {
        // Hapus dari database
        $stmt = $pdo->prepare("DELETE FROM genres WHERE id = ?");
        $stmt->execute([$genre_id]);
        
        echo "<div class='alert alert-success'>Genre berhasil dihapus!</div>";
        echo "<a href='index.php' class='btn'>Kembali ke Daftar Genre</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal menghapus genre: " . $e->getMessage() . "</div>";
        echo "<a href='index.php' class='btn'>Kembali</a>";
    }
} else {
    echo "<h2>Konfirmasi Hapus Genre</h2>";
    echo "<p>Apakah Anda yakin ingin menghapus genre berikut?</p>";
    echo "<div class='genre-preview'>";
    echo "<h3>" . $genre['name'] . "</h3>";
    echo "<p>" . $genre['description'] . "</p>";
    echo "</div>";
    
    echo "<form method='post'>";
    echo "<input type='hidden' name='confirm' value='1'>";
    echo "<input type='submit' value='Ya, Hapus Genre Ini' class='btn btn-danger'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>