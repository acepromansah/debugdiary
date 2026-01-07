<?php
ob_start();
session_start();

require 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$login_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];             
                    header("Location: index.php");
                    exit;
                }
            }
            $login_message = "Username atau password salah";
        } else {
            $login_message = "Harap isi semua kolom";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/debugdiary/style.css">
    <title>Login</title>
</head>
<body>
    <div class="auth-container">
        <div class="login-container">
            <div class="logo">📝 Debug Diary</div>
            <form action="login.php" method="POST" >
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" name="login" class="btn-primary">LOGIN</button>
            </form>

            <div class="signup-link">
            Don't have an account? <a href="register.html">Create an Account</a>
            </div>

            <?php if ($login_message): ?>
                <div class="error"><?= htmlspecialchars($login_message) ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
