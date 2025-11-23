<?php
// Edit penulis
require_once '../../config.php';
require_once '../../includes/header.php';
require_once '../../includes/functions.php';
require_once '../../includes/db_connect.php';
require_once '../../includes/auth_check.php';

require_login(); // Harus login untuk mengedit penulis

$page_title = "Edit Penulis";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$author_id = (int)$_GET['id'];

// Ambil data penulis
$stmt = $pdo->prepare("SELECT * FROM authors WHERE id = ?");
$stmt->execute([$author_id]);
$author = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$author) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $name = sanitize_input($_POST['name']);
    $biography = sanitize_input($_POST['biography']);
    $birth_date = $_POST['birth_date'] ?? null;
    $death_date = $_POST['death_date'] ?? null;
    $nationality = sanitize_input($_POST['nationality']);
    
    // Upload foto jika ada
    $photo = $author['photo']; // Gunakan foto yang lama sebagai default
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Hapus foto lama jika ada
        if ($author['photo'] && file_exists(AUTHOR_UPLOAD_PATH . $author['photo'])) {
            unlink(AUTHOR_UPLOAD_PATH . $author['photo']);
        }
        
        $upload_result = upload_file($_FILES['photo'], AUTHOR_UPLOAD_PATH);
        if ($upload_result['success']) {
            $photo = $upload_result['filename'];
        } else {
            $error = $upload_result['message'];
        }
    }
    
    if (empty($error)) {
        try {
            // Update database
            $stmt = $pdo->prepare("UPDATE authors SET name=?, biography=?, birth_date=?, death_date=?, nationality=?, photo=? WHERE id=?");
            $stmt->execute([$name, $biography, $birth_date, $death_date, $nationality, $photo, $author_id]);
            
            echo "<div class='alert alert-success'>Penulis berhasil diperbarui!</div>";
            echo "<a href='index.php'>Kembali ke Daftar Penulis</a>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-error'>Gagal memperbarui penulis: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-error'>$error</div>";
    }
} else {
    echo "<h2>Edit Penulis: " . $author['name'] . "</h2>";
    
    echo "<form method='post' enctype='multipart/form-data'>";
    echo "<div class='form-group'>";
    echo "<label for='name'>Nama Penulis:</label>";
    echo "<input type='text' id='name' name='name' value='" . htmlspecialchars($author['name']) . "' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='biography'>Biografi:</label>";
    echo "<textarea id='biography' name='biography'>" . htmlspecialchars($author['biography']) . "</textarea>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='birth_date'>Tanggal Lahir:</label>";
    echo "<input type='date' id='birth_date' name='birth_date' value='" . ($author['birth_date'] ?? '') . "'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='death_date'>Tanggal Wafat:</label>";
    echo "<input type='date' id='death_date' name='death_date' value='" . ($author['death_date'] ?? '') . "'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='nationality'>Kebangsaan:</label>";
    echo "<input type='text' id='nationality' name='nationality' value='" . htmlspecialchars($author['nationality'] ?? '') . "'>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='photo'>Foto Penulis:</label>";
    if ($author['photo']) {
        echo "<div><img src='" . AUTHOR_UPLOAD_PATH . $author['photo'] . "' width='100' alt='Foto'></div>";
    }
    echo "<input type='file' id='photo' name='photo' accept='image/*'>";
    echo "<small>Biarkan kosong jika tidak ingin mengganti foto</small>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Perbarui Penulis' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once '../../includes/footer.php';
?>