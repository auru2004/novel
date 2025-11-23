<?php
// Daftar peminjaman
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

require_login(); // Harus login untuk melihat peminjaman

$page_title = "Daftar Peminjaman";

echo "<h2>Daftar Peminjaman Buku</h2>";

// Join untuk mendapatkan informasi buku dan peminjam
$stmt = $pdo->query("SELECT l.*, b.title as book_title, u.username as borrower_name
                     FROM lending l
                     LEFT JOIN books b ON l.book_id = b.id
                     LEFT JOIN users u ON l.user_id = u.id
                     ORDER BY l.borrow_date DESC");
$lendings = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<div class='lendings-list'>";
if (count($lendings) > 0) {
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Buku</th>";
    echo "<th>Peminjam</th>";
    echo "<th>Tanggal Pinjam</th>";
    echo "<th>Tanggal Kembali</th>";
    echo "<th>Status</th>";
    echo "<th>Aksi</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($lendings as $lending) {
        echo "<tr>";
        echo "<td>" . $lending['id'] . "</td>";
        echo "<td>" . $lending['book_title'] . "</td>";
        echo "<td>" . $lending['borrower_name'] . "</td>";
        echo "<td>" . format_date($lending['borrow_date']) . "</td>";
        echo "<td>" . ($lending['return_date'] ? format_date($lending['return_date']) : 'Belum Dikembalikan') . "</td>";
        echo "<td>" . ($lending['is_returned'] ? 'Sudah Dikembalikan' : 'Belum Dikembalikan') . "</td>";
        echo "<td>";
        if (!$lending['is_returned']) {
            echo "<a href='return.php?id=" . $lending['id'] . "'>Kembalikan</a>";
        } else {
            echo "Selesai";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Belum ada data peminjaman.</p>";
}
echo "</div>";

echo "<div class='actions'>";
echo "<a href='borrow.php' class='btn btn-primary'>Peminjaman Baru</a>";
echo "</div>";

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>