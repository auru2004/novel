<?php
// Hapus penulis
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk menghapus penulis

$page_title = "Hapus Penulis";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$author_id = (int)$_GET['id'];

// Ambil data penulis
$stmt = $pdo->prepare("SELECT * FROM authors WHERE id = ?");
$stmt->execute([$author_id]);
$author = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$author) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    try {
        // Hapus foto jika ada
        if ($author['photo'] && file_exists(AUTHOR_UPLOAD_PATH . $author['photo'])) {
            unlink(AUTHOR_UPLOAD_PATH . $author['photo']);
        }
        
        // Hapus dari database
        $stmt = $pdo->prepare("DELETE FROM authors WHERE id = ?");
        $stmt->execute([$author_id]);
        
        echo "<div class='alert alert-success'>Penulis berhasil dihapus!</div>";
        echo "<a href='index.php' class='btn'>Kembali ke Daftar Penulis</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal menghapus penulis: " . $e->getMessage() . "</div>";
        echo "<a href='index.php' class='btn'>Kembali</a>";
    }
} else {
    echo "<h2>Konfirmasi Hapus Penulis</h2>";
    echo "<p>Apakah Anda yakin ingin menghapus penulis berikut?</p>";
    echo "<div class='author-preview'>";
    echo "<h3>" . $author['name'] . "</h3>";
    if ($author['photo']) {
        echo "<img src='" . AUTHOR_UPLOAD_PATH . $author['photo'] . "' width='100' alt='Foto'>";
    }
    echo "<p>" . (strlen($author['biography']) > 100 ? substr($author['biography'], 0, 100) . '...' : $author['biography']) . "</p>";
    echo "</div>";
    
    echo "<form method='post'>";
    echo "<input type='hidden' name='confirm' value='1'>";
    echo "<input type='submit' value='Ya, Hapus Penulis Ini' class='btn btn-danger'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>