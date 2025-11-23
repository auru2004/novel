<?php
// List penulis
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

$page_title = "Daftar Penulis";

echo "<h2>Daftar Penulis</h2>";

// Query untuk mengambil semua penulis
$stmt = $pdo->query("SELECT * FROM authors ORDER BY name");
$authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='authors-list'>";
if (count($authors) > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nama</th>";
    echo "<th>Biografi</th>";
    echo "<th>Negara Asal</th>";
    echo "<th>Aksi</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($authors as $author) {
        echo "<tr>";
        echo "<td>" . $author['id'] . "</td>";
        echo "<td>" . $author['name'] . "</td>";
        echo "<td>" . (strlen($author['biography']) > 50 ? substr($author['biography'], 0, 50) . '...' : $author['biography']) . "</td>";
        echo "<td>" . ($author['country'] ?? 'Tidak Diketahui') . "</td>";
        echo "<td>";
        echo "<a href='edit.php?id=" . $author['id'] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $author['id'] . "' onclick=\"return confirm('Yakin ingin menghapus penulis ini?')\">Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Belum ada data penulis.</p>";
}
echo "</div>";

echo "<div class='actions'>";
echo "<a href='create.php' class='btn btn-primary'>Tambah Penulis</a>";
echo "</div>";

require_once '../../includes/footer.php';
?>