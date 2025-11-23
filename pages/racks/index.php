<?php
// List rak buku
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

$page_title = "Daftar Rak Buku";

echo "<h2>Daftar Rak Buku</h2>";

// Query untuk mengambil semua rak
$stmt = $pdo->query("SELECT * FROM racks ORDER BY name");
$racks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='racks-list'>";
if (count($racks) > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nama</th>";
    echo "<th>Lokasi</th>";
    echo "<th>Deskripsi</th>";
    echo "<th>Aksi</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($racks as $rack) {
        echo "<tr>";
        echo "<td>" . $rack['id'] . "</td>";
        echo "<td>" . $rack['name'] . "</td>";
        echo "<td>" . ($rack['location'] ?? 'Tidak Diketahui') . "</td>";
        echo "<td>" . (strlen($rack['description']) > 50 ? substr($rack['description'], 0, 50) . '...' : $rack['description']) . "</td>";
        echo "<td>";
        echo "<a href='edit.php?id=" . $rack['id'] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $rack['id'] . "' onclick=\"return confirm('Yakin ingin menghapus rak ini?')\">Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Belum ada data rak buku.</p>";
}
echo "</div>";

echo "<div class='actions'>";
echo "<a href='create.php' class='btn btn-primary'>Tambah Rak</a>";
echo "</div>";

require_once '../../includes/footer.php';
?>