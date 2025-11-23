<?php
// Login
require_once dirname(__DIR__, 2) . '/includes/init.php';
require_once dirname(__DIR__, 2) . '/includes/header.php';

$page_title = "Login";

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    redirect('pages/dashboard/index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];

    try {
        // Cek user di database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            redirect('pages/dashboard/index.php');
        } else {
            $error = "Username atau password salah";
        }
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan: " . $e->getMessage();
    }
}

echo "<h2>Login</h2>";

if (isset($error)) {
    echo "<div class='alert alert-error'>$error</div>";
}

echo "<form method='post'>";
echo "<div class='form-group'>";
echo "<label for='username'>Username:</label>";
echo "<input type='text' id='username' name='username' required>";
echo "</div>";

echo "<div class='form-group'>";
echo "<label for='password'>Password:</label>";
echo "<input type='password' id='password' name='password' required>";
echo "</div>";

echo "<div class='form-group'>";
echo "<input type='submit' value='Login' class='btn btn-primary'>";
echo "</div>";
echo "</form>";

echo "<p>Belum punya akun? <a href='register.php'>Daftar di sini</a></p>";

require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>