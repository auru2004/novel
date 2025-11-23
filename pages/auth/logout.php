<?php
// Logout
require_once dirname(__DIR__, 2) . '/includes/init.php';

// Hapus semua session
session_destroy();

// Arahkan ke halaman login
redirect('pages/auth/login.php');
?>