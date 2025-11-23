<?php
// Profile user
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

require_login(); // Pastikan user login

$page_title = "Profil";

echo "<h2>Profil Pengguna</h2>";
echo "<p>Informasi profil pengguna</p>";

// Tampilkan informasi pengguna
if (isset($_SESSION['user_id'])) {
    echo "<div class='profile-info'>";
    echo "<p>Nama: " . ($_SESSION['username'] ?? 'Nama Pengguna') . "</p>";
    echo "<p>Email: " . ($_SESSION['email'] ?? 'Email Tidak Tersedia') . "</p>";
    echo "<p>Role: " . ucfirst($_SESSION['role'] ?? 'user') . "</p>";
    echo "</div>";
}

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>