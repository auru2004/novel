<?php
// Cek login & role user
require_once dirname(__DIR__) . '/includes/db_connect.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect('pages/auth/login.php');
    }
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_admin() {
    if (!is_logged_in() || !is_admin()) {
        redirect('pages/errors/403.php');
    }
}

// Fungsi untuk cek hak akses berdasarkan role
function check_permission($required_role = 'user') {
    if (!is_logged_in()) {
        redirect('pages/auth/login.php');
    }

    $user_role = $_SESSION['role'] ?? 'user';

    if ($required_role === 'admin' && $user_role !== 'admin') {
        redirect('pages/errors/403.php');
    }
}
?>