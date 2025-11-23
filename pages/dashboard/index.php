<?php
// Dashboard ringkasan koleksi
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

require_login(); // Pastikan user login

$page_title = "Dashboard";

echo "<h2>Dashboard</h2>";
echo "<p>Ringkasan koleksi buku novel Anda</p>";

// Ambil jumlah buku
$stmt = $pdo->query("SELECT COUNT(*) as total FROM books");
$total_books = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil jumlah penulis
$stmt = $pdo->query("SELECT COUNT(*) as total FROM authors");
$total_authors = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil jumlah genre
$stmt = $pdo->query("SELECT COUNT(*) as total FROM genres");
$total_genres = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Ambil jumlah rak
$stmt = $pdo->query("SELECT COUNT(*) as total FROM racks");
$total_racks = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

echo "<div class='dashboard-stats'>";
echo "<div class='stat-card'>";
echo "<h3>" . format_number($total_books) . "</h3>";
echo "<p>Total Buku</p>";
echo "</div>";

echo "<div class='stat-card'>";
echo "<h3>" . format_number($total_authors) . "</h3>";
echo "<p>Total Penulis</p>";
echo "</div>";

echo "<div class='stat-card'>";
echo "<h3>" . format_number($total_genres) . "</h3>";
echo "<p>Total Genre</p>";
echo "</div>";

echo "<div class='stat-card'>";
echo "<h3>" . format_number($total_racks) . "</h3>";
echo "<p>Total Rak</p>";
echo "</div>";
echo "</div>";

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>