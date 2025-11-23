<?php
// Input pengembalian
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk pengembalian

$page_title = "Pengembalian Buku";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$lending_id = (int)$_GET['id'];

// Ambil detail peminjaman
$stmt = $pdo->prepare("SELECT l.*, b.title as book_title, u.username as borrower_name, b.id as book_id
                      FROM lending l
                      LEFT JOIN books b ON l.book_id = b.id
                      LEFT JOIN users u ON l.user_id = u.id
                      WHERE l.id = ?");
$stmt->execute([$lending_id]);
$lending = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lending || $lending['is_returned']) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $return_date = $_POST['return_date'];
    
    try {
        // Tambah jumlah buku yang tersedia
        $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
        $stmt->execute([$lending['book_id']]);
        
        // Update status peminjaman
        $stmt = $pdo->prepare("UPDATE lending SET return_date = ?, is_returned = 1 WHERE id = ?");
        $stmt->execute([$return_date, $lending_id]);
        
        echo "<div class='alert alert-success'>Pengembalian berhasil dicatat!</div>";
        echo "<a href='index.php'>Kembali ke Daftar Peminjaman</a>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal mencatat pengembalian: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<h2>Pengembalian Buku</h2>";
    echo "<div class='book-info'>";
    echo "<p><strong>Buku:</strong> " . $lending['book_title'] . "</p>";
    echo "<p><strong>Peminjam:</strong> " . $lending['borrower_name'] . "</p>";
    echo "<p><strong>Tanggal Pinjam:</strong> " . format_date($lending['borrow_date']) . "</p>";
    echo "<p><strong>Tanggal Harus Kembali:</strong> " . format_date($lending['due_date']) . "</p>";
    echo "</div>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='return_date'>Tanggal Dikembalikan:</label>";
    echo "<input type='date' id='return_date' name='return_date' value='" . date('Y-m-d') . "' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Catat Pengembalian' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>