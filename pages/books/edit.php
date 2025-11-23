<?php
// Edit data novel
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

require_login(); // Harus login untuk mengedit buku

$page_title = "Edit Buku";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('pages/books/index.php');
}

$book_id = (int)$_GET['id'];

// Ambil data buku
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    redirect('pages/books/index.php');
}

// Ambil data untuk dropdown
$authors = $pdo->query("SELECT id, name FROM authors ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$genres = $pdo->query("SELECT id, name FROM genres ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$racks = $pdo->query("SELECT id, name FROM racks ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input
    $title = sanitize_input($_POST['title']);
    $author_id = (int)$_POST['author_id'];
    $genre_id = (int)$_POST['genre_id'];
    $publication_year = (int)$_POST['publication_year'];
    $isbn = sanitize_input($_POST['isbn']);
    $description = sanitize_input($_POST['description']);
    $rack_id = (int)$_POST['rack_id'];
    $total_copies = (int)$_POST['total_copies'];
    $available_copies = (int)$_POST['available_copies'];

    // Upload cover jika ada
    $cover_image = $book['cover_image']; // Gunakan cover yang lama sebagai default
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        // Hapus cover lama jika ada
        if ($book['cover_image'] && file_exists(COVER_UPLOAD_PATH . $book['cover_image'])) {
            unlink(COVER_UPLOAD_PATH . $book['cover_image']);
        }

        $upload_result = upload_file($_FILES['cover_image'], COVER_UPLOAD_PATH);
        if ($upload_result['success']) {
            $cover_image = $upload_result['filename'];
        } else {
            $error = $upload_result['message'];
        }
    }

    if (empty($error)) {
        try {
            // Update database
            $stmt = $pdo->prepare("UPDATE books SET title=?, author_id=?, genre_id=?, publication_year=?, isbn=?, description=?, rack_id=?, total_copies=?, available_copies=?, cover_image=? WHERE id=?");
            $stmt->execute([$title, $author_id, $genre_id, $publication_year, $isbn, $description, $rack_id, $total_copies, $available_copies, $cover_image, $book_id]);

            echo "<div class='alert alert-success'>Buku berhasil diperbarui!</div>";
            echo "<a href='index.php'>Kembali ke Daftar Buku</a>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-error'>Gagal memperbarui buku: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-error'>$error</div>";
    }
} else {
    echo "<h2>Edit Buku: " . $book['title'] . "</h2>";

    echo "<form method='post' enctype='multipart/form-data'>";
    echo "<div class='form-group'>";
    echo "<label for='title'>Judul Buku:</label>";
    echo "<input type='text' id='title' name='title' value='" . htmlspecialchars($book['title']) . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='author_id'>Penulis:</label>";
    echo "<select id='author_id' name='author_id' required>";
    echo "<option value=''>Pilih Penulis</option>";
    foreach ($authors as $author) {
        $selected = $author['id'] == $book['author_id'] ? 'selected' : '';
        echo "<option value='{$author['id']}' $selected>{$author['name']}</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='genre_id'>Genre:</label>";
    echo "<select id='genre_id' name='genre_id' required>";
    echo "<option value=''>Pilih Genre</option>";
    foreach ($genres as $genre) {
        $selected = $genre['id'] == $book['genre_id'] ? 'selected' : '';
        echo "<option value='{$genre['id']}' $selected>{$genre['name']}</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='publication_year'>Tahun Terbit:</label>";
    echo "<input type='number' id='publication_year' name='publication_year' min='1000' max='2030' value='{$book['publication_year']}' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='isbn'>ISBN:</label>";
    echo "<input type='text' id='isbn' name='isbn' value='" . htmlspecialchars($book['isbn']) . "'>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='description'>Deskripsi:</label>";
    echo "<textarea id='description' name='description'>" . htmlspecialchars($book['description']) . "</textarea>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='rack_id'>Rak Buku:</label>";
    echo "<select id='rack_id' name='rack_id'>";
    echo "<option value=''>Pilih Rak</option>";
    foreach ($racks as $rack) {
        $selected = $rack['id'] == $book['rack_id'] ? 'selected' : '';
        echo "<option value='{$rack['id']}' $selected>{$rack['name']}</option>";
    }
    echo "</select>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='total_copies'>Jumlah Total:</label>";
    echo "<input type='number' id='total_copies' name='total_copies' min='1' value='{$book['total_copies']}' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='available_copies'>Jumlah Tersedia:</label>";
    echo "<input type='number' id='available_copies' name='available_copies' min='0' value='{$book['available_copies']}' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='cover_image'>Cover Buku:</label>";
    if ($book['cover_image']) {
        echo "<div><img src='" . COVER_UPLOAD_PATH . $book['cover_image'] . "' width='100' alt='Cover'></div>";
    }
    echo "<input type='file' id='cover_image' name='cover_image' accept='image/*'>";
    echo "<small>Biarkan kosong jika tidak ingin mengganti cover</small>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<input type='submit' value='Perbarui Buku' class='btn btn-primary'>";
    echo "<a href='index.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
}

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>