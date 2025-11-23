<?php
// List genre
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

$page_title = "Daftar Genre";

echo "<h2>Daftar Genre Buku</h2>";

// Query untuk mengambil semua genre
$stmt = $pdo->query("SELECT * FROM genres ORDER BY name");
$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='genres-list'>";
if (count($genres) > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nama</th>";
    echo "<th>Deskripsi</th>";
    echo "<th>Aksi</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($genres as $genre) {
        echo "<tr>";
        echo "<td>" . $genre['id'] . "</td>";
        echo "<td>" . $genre['name'] . "</td>";
        echo "<td>" . (strlen($genre['description']) > 50 ? substr($genre['description'], 0, 50) . '...' : $genre['description']) . "</td>";
        echo "<td>";
        echo "<a href='edit.php?id=" . $genre['id'] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $genre['id'] . "' onclick=\"return confirm('Yakin ingin menghapus genre ini?')\">Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Belum ada data genre.</p>";
}
echo "</div>";

echo "<div class='actions'>";
echo "<a href='create.php' class='btn btn-primary'>Tambah Genre</a>";
echo "</div>";

require_once '../../includes/footer.php';
?>