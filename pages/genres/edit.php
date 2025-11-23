<?php
// Edit genre
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk mengedit genre

$page_title = "Edit Genre";

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    
    try {
        // Update database
        $stmt = $pdo->prepare("UPDATE genres SET name=?, description=? WHERE id=?");
        $stmt->execute([$name, $description, $genre_id]);
        
        echo "<div class='alert alert-success'>Genre berhasil diperbarui!</div>";
        echo "<a href='index.php'>Kembali ke Daftar Genre</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal memperbarui genre: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<h2>Edit Genre: " . $genre['name'] . "</h2>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Nama Genre:</label>";
    echo "<input type='text' id='name' name='name' value='" . htmlspecialchars($genre['name']) . "' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='description'>Deskripsi:</label>";
    echo "<textarea id='description' name='description'>" . htmlspecialchars($genre['description']) . "</textarea>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Perbarui Genre' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>