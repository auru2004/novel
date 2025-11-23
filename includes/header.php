<?php
// Header HTML & Navigation
require_once dirname(__DIR__) . '/includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <h1><a href="<?php echo BASE_URL; ?>/index.php"><?php echo SITE_NAME; ?></a></h1>
            </div>
            <ul class="nav-menu">
                <li><a href="<?php echo BASE_URL; ?>/index.php">Beranda</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/books/index.php">Buku</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/authors/index.php">Penulis</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/genres/index.php">Genre</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/racks/index.php">Rak Buku</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/lending/index.php">Peminjaman</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo BASE_URL; ?>/pages/profile/index.php">Profil</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/auth/logout.php">Logout</a></li>
                <?php else: ?>
                <li><a href="<?php echo BASE_URL; ?>/pages/auth/login.php">Login</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pages/auth/register.php">Daftar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>