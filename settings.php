<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - Debug Diary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app-container">

    <!-- SIDEBAR (boleh copy dari index.php) -->
    <aside class="sidebar">
        <div class="logo-app">📝 Debug Diary</div>
        <nav>
            <ul>
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="notes.php">📋 Tambah Catatan</a></li>
                <li><a href="analytics.php">📊 Analytics</a></li>
                <li><a href="forum.php">💬 Forum</a></li>
                <li><a href="settings.php" class="active">⚙️Settings</a></li>
                <li><a href="logout.php">🚪 Log Out</a></li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="main-content">
        <header class="header">
            <h1>Settings</h1>
        </header>

        <div class="settings-card">
            <h3>Profil</h3>
            <p><b>Username:</b> <?= htmlspecialchars($username) ?></p>

            <hr>

            <h3 style="color:red;">Hapus Akun</h3>
            <p style="color:red;">
                ⚠️ Akun akan dihapus permanen dan tidak bisa dikembalikan.
            </p>

            <form action="delete_account.php" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus akun?');">
                <button type="submit" name="delete" class="danger-btn">
                    Hapus Akun
                </button>
            </form>
        </div>
    </main>

</div>

</body>
</html>
