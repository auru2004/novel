<?php
// Konfigurasi database & konstanta

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'novel_collection');

// Application constants
define('SITE_NAME', 'Koleksi Buku Novel');
define('BASE_URL', 'http://localhost/novel');

// Upload paths
define('COVER_UPLOAD_PATH', 'assets/uploads/covers/');
define('AUTHOR_UPLOAD_PATH', 'assets/uploads/authors/');

// Other configurations
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
?>