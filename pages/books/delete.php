<?php
// Hapus novel
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

require_login(); // Harus login untuk menghapus buku

$page_title = "Hapus Buku";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('pages/books/index.php');
}

$book_id = (int)$_GET['id'];

// Ambil data buku
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    redirect('pages/books/index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    try {
        // Hapus cover jika ada
        if ($book['cover_image'] && file_exists(COVER_UPLOAD_PATH . $book['cover_image'])) {
            unlink(COVER_UPLOAD_PATH . $book['cover_image']);
        }

        // Hapus dari database
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$book_id]);

        echo "<div class='alert alert-success'>Buku berhasil dihapus!</div>";
        echo "<a href='index.php' class='btn'>Kembali ke Daftar Buku</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal menghapus buku: " . $e->getMessage() . "</div>";
        echo "<a href='index.php' class='btn'>Kembali</a>";
    }
} else {
    echo "<h2>Konfirmasi Hapus Buku</h2>";
    echo "<p>Apakah Anda yakin ingin menghapus buku berikut?</p>";
    echo "<div class='book-preview'>";
    echo "<h3>" . $book['title'] . "</h3>";
    if ($book['cover_image']) {
        echo "<img src='" . COVER_UPLOAD_PATH . $book['cover_image'] . "' width='100' alt='Cover'>";
    }
    echo "<p>Penulis: " . ($book['author_name'] ?? 'Tidak Diketahui') . "</p>";
    echo "</div>";

    echo "<form method='post'>";
    echo "<input type='hidden' name='confirm' value='1'>";
    echo "<input type='submit' value='Ya, Hapus Buku Ini' class='btn btn-danger'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</form>";
}

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>