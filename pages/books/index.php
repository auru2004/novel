<?php
// Daftar semua novel
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

$page_title = "Daftar Buku";

echo "<h2>Daftar Buku Novel</h2>";

// Query untuk mengambil semua buku
$stmt = $pdo->query("SELECT b.*, a.name as author_name, g.name as genre_name, r.name as rack_name
                     FROM books b
                     LEFT JOIN authors a ON b.author_id = a.id
                     LEFT JOIN genres g ON b.genre_id = g.id
                     LEFT JOIN racks r ON b.rack_id = r.id
                     ORDER BY b.title");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='books-list'>";
if (count($books) > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Cover</th>";
    echo "<th>Judul</th>";
    echo "<th>Penulis</th>";
    echo "<th>Genre</th>";
    echo "<th>Tahun Terbit</th>";
    echo "<th>Rak</th>";
    echo "<th>Aksi</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($books as $book) {
        echo "<tr>";
        echo "<td>";
        if ($book['cover_image']) {
            echo "<img src='" . COVER_UPLOAD_PATH . $book['cover_image'] . "' alt='" . $book['title'] . "' width='50'>";
        } else {
            echo "No Cover";
        }
        echo "</td>";
        echo "<td>" . $book['title'] . "</td>";
        echo "<td>" . ($book['author_name'] ?? 'Tidak Diketahui') . "</td>";
        echo "<td>" . ($book['genre_name'] ?? 'Tidak Diketahui') . "</td>";
        echo "<td>" . $book['publication_year'] . "</td>";
        echo "<td>" . ($book['rack_name'] ?? 'Tidak Ditentukan') . "</td>";
        echo "<td>";
        echo "<a href='detail.php?id=" . $book['id'] . "'>Detail</a> | ";
        echo "<a href='edit.php?id=" . $book['id'] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $book['id'] . "' onclick=\"return confirm('Yakin ingin menghapus buku ini?')\">Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Belum ada buku dalam koleksi.</p>";
}
echo "</div>";

echo "<div class='actions'>";
echo "<a href='create.php' class='btn btn-primary'>Tambah Buku Baru</a>";
echo "</div>";

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>