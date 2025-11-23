<?php
// Fungsi-fungsi helper

/**
 * Redirect ke halaman tertentu
 */
function redirect($page) {
    // Jika URL tidak dimulai dengan http, tambahkan base URL
    if (!preg_match('/^https?:\/\//', $page)) {
        $page = BASE_URL . '/' . $page;
    }
    header("Location: $page");
    exit();
}

/**
 * Sanitasi input
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Format tanggal
 */
function format_date($date) {
    return date('d M Y', strtotime($date));
}

/**
 * Upload file
 */
function upload_file($file, $target_dir, $allowed_types = ALLOWED_IMAGE_TYPES) {
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Cek apakah file adalah gambar
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return ['success' => false, 'message' => 'File bukan gambar'];
    }
    
    // Cek ukuran file
    if ($file["size"] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar'];
    }
    
    // Cek tipe file
    if (!in_array($imageFileType, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }
    
    // Generate nama file unik
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'message' => 'Gagal mengupload file'];
    }
}

/**
 * Format angka
 */
function format_number($number) {
    return number_format($number, 0, ',', '.');
}
?>