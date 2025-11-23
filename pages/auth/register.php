<?php
// Register
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

$page_title = "Registrasi";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username harus diisi";
    }
    
    if (empty($email)) {
        $errors[] = "Email harus diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($password)) {
        $errors[] = "Password harus diisi";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password harus minimal 6 karakter";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak cocok";
    }
    
    // Cek apakah username atau email sudah digunakan
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existing_user = $stmt->fetch();
        
        if ($existing_user) {
            $errors[] = "Username atau email sudah digunakan";
        }
    }
    
    if (empty($errors)) {
        try {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user ke database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, 'user', NOW())");
            $stmt->execute([$username, $email, $hashed_password]);
            
            echo "<div class='alert alert-success'>Registrasi berhasil! Silakan <a href='login.php'>login</a> untuk masuk.</div>";
        } catch (PDOException $e) {
            $errors[] = "Terjadi kesalahan saat registrasi: " . $e->getMessage();
        }
    }
    
    // Tampilkan error jika ada
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-error'>$error</div>";
        }
    }
} else {
    echo "<h2>Daftar Akun Baru</h2>";
    
    echo "<form method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='username'>Username:</label>";
    echo "<input type='text' id='username' name='username' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='email'>Email:</label>";
    echo "<input type='email' id='email' name='email' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='password'>Password:</label>";
    echo "<input type='password' id='password' name='password' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<label for='confirm_password'>Konfirmasi Password:</label>";
    echo "<input type='password' id='confirm_password' name='confirm_password' required>";
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo "<input type='submit' value='Daftar' class='btn btn-primary'>";
    echo "<a href='login.php' class='btn'>Batal</a>";
    echo "</div>";
    echo "</form>";
    
    echo "<p>Sudah punya akun? <a href='login.php'>Login di sini</a></p>";
}

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>