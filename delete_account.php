<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Hapus data forum (jika ada)
mysqli_query($conn, "DELETE FROM forum_comments WHERE username='$username'");
mysqli_query($conn, "DELETE FROM forum_posts WHERE username='$username'");

// Hapus user
mysqli_query($conn, "DELETE FROM users WHERE username='$username'");

// Logout otomatis
session_destroy();
header("Location: login.php");
exit;
