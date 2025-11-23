<?php
// Tambah penulis
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk menambah penulis

$page_title = "Tambah Penulis";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $name = sanitize_input($_POST['name']);
    $biography = sanitize_input($_POST['biography']);
    $birth_date = $_POST['birth_date'] ?? null;
    $death_date = $_POST['death_date'] ?? null;
    $nationality = sanitize_input($_POST['nationality']);
    
    // Upload foto jika ada
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_result = upload_file($_FILES['photo'], AUTHOR_UPLOAD_PATH);
        if ($upload_result['success']) {
            $photo = $upload_result['filename'];
        } else {
            $error = $upload_result['message'];
        }
    }
    
    if (empty($error)) {
        try {
            // Insert ke database
            $stmt = $pdo->prepare("INSERT INTO authors (name, biography, birth_date, death_date, nationality, photo, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $biography, $birth_date, $death_date, $nationality, $photo]);
            
            echo "<div class='alert alert-success'>Penulis berhasil ditambahkan!</div>";
            echo "<a href='index.php'>Kembali ke Daftar Penulis</a>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-error'>Gagal menambahkan penulis: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-error'>$error</div>";
    }
} else {
    echo "<h2>Tambah Penulis Baru</h2>";
    
    echo "<form method='post' enctype='multipart/form-data'>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Nama Penulis:</label>";
    echo "<input type='text' id='name' name='name' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='biography'>Biografi:</label>";
    echo "<textarea id='biography' name='biography'></textarea>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='birth_date'>Tanggal Lahir:</label>";
    echo "<input type='date' id='birth_date' name='birth_date'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='death_date'>Tanggal Wafat:</label>";
    echo "<input type='date' id='death_date' name='death_date'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='nationality'>Kebangsaan:</label>";
    echo "<input type='text' id='nationality' name='nationality'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='photo'>Foto Penulis:</label>";
    echo "<input type='file' id='photo' name='photo' accept='image/*'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Simpan Penulis' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>