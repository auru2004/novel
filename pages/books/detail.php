<?php
// Detail novel
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

$page_title = "Detail Buku";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('pages/books/index.php');
}

$book_id = (int)$_GET['id'];

// Ambil data buku lengkap
$stmt = $pdo->prepare("SELECT b.*, a.name as author_name, g.name as genre_name, r.name as rack_name
                      FROM books b
                      LEFT JOIN authors a ON b.author_id = a.id
                      LEFT JOIN genres g ON b.genre_id = g.id
                      LEFT JOIN racks r ON b.rack_id = r.id
                      WHERE b.id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    redirect('pages/books/index.php');
}

echo "<div class='book-detail'>";
echo "<h2>Detail Buku: " . $book['title'] . "</h2>";

echo "<div class='book-info'>";
if ($book['cover_image']) {
    echo "<div class='cover-section'>";
    echo "<img src='" . COVER_UPLOAD_PATH . $book['cover_image'] . "' alt='Cover " . $book['title'] . "' class='book-cover'>";
    echo "</div>";
}

echo "<div class='details-section'>";
echo "<p><strong>Judul:</strong> " . $book['title'] . "</p>";
echo "<p><strong>Penulis:</strong> " . ($book['author_name'] ?? 'Tidak Diketahui') . "</p>";
echo "<p><strong>Genre:</strong> " . ($book['genre_name'] ?? 'Tidak Diketahui') . "</p>";
echo "<p><strong>Tahun Terbit:</strong> " . $book['publication_year'] . "</p>";
echo "<p><strong>ISBN:</strong> " . ($book['isbn'] ?? '-') . "</p>";
echo "<p><strong>Rak Buku:</strong> " . ($book['rack_name'] ?? 'Tidak Ditentukan') . "</p>";
echo "<p><strong>Jumlah Total:</strong> " . $book['total_copies'] . "</p>";
echo "<p><strong>Tersedia:</strong> " . $book['available_copies'] . "</p>";
echo "<p><strong>Status:</strong> " . ($book['available_copies'] > 0 ? 'Tersedia' : 'Dipinjam Semua') . "</p>";
echo "<p><strong>Deskripsi:</strong><br>" . (nl2br(htmlspecialchars($book['description'])) ?? 'Tidak Ada Deskripsi') . "</p>";
echo "</div>";
echo "</div>";

echo "<div class='actions'>";
echo "<a href='edit.php?id=" . $book['id'] . "' class='btn btn-primary'>Edit Buku</a> ";
echo "<a href='index.php' class='btn'>Kembali ke Daftar</a>";
echo "</div>";

echo "</div>";

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>