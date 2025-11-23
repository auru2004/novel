<?php
// Input peminjaman
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk peminjaman

$page_title = "Peminjaman Buku";

// Ambil data untuk dropdown
$users = $pdo->query("SELECT id, username FROM users ORDER BY username")->fetchAll(PDO::FETCH_ASSOC);
$books = $pdo->query("SELECT b.id, b.title, a.name as author_name 
                     FROM books b
                     LEFT JOIN authors a ON b.author_id = a.id
                     WHERE b.available_copies > 0
                     ORDER BY b.title")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_POST['user_id'];
    $book_id = (int)$_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];
    
    try {
        // Kurangi jumlah buku yang tersedia
        $stmt = $pdo->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ? AND available_copies > 0");
        $result = $stmt->execute([$book_id]);
        
        if ($stmt->rowCount() > 0) {
            // Simpan data peminjaman
            $stmt = $pdo->prepare("INSERT INTO lending (user_id, book_id, borrow_date, due_date, is_returned) VALUES (?, ?, ?, ?, 0)");
            $stmt->execute([$user_id, $book_id, $borrow_date, $due_date]);
            
            echo "<div class='alert alert-success'>Peminjaman berhasil dicatat!</div>";
            echo "<a href='index.php'>Kembali ke Daftar Peminjaman</a>";
        } else {
            echo "<div class='alert alert-error'>Gagal: Buku tidak tersedia atau stok habis.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-error'>Gagal mencatat peminjaman: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<h2>Peminjaman Buku Baru</h2>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='user_id'>Peminjam:</label>";
    echo "<select id='user_id' name='user_id' required>";
    echo "<option value=''>Pilih Peminjam</option>";
    foreach ($users as $user) {
        echo "<option value='{$user['id']}'>{$user['username']}</option>";
    }
    echo "</select>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='book_id'>Buku:</label>";
    echo "<select id='book_id' name='book_id' required>";
    echo "<option value=''>Pilih Buku</option>";
    foreach ($books as $book) {
        echo "<option value='{$book['id']}'>{$book['title']} oleh {$book['author_name']}</option>";
    }
    echo "</select>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='borrow_date'>Tanggal Pinjam:</label>";
    echo "<input type='date' id='borrow_date' name='borrow_date' value='" . date('Y-m-d') . "' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='due_date'>Tanggal Harus Kembali:</label>";
    echo "<input type='date' id='due_date' name='due_date' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Catat Peminjaman' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>