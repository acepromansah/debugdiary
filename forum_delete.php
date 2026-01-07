<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

$post = mysqli_query($conn, "SELECT * FROM forum_posts WHERE id=$id");
$data = mysqli_fetch_assoc($post);

if (!$data || $data['username'] !== $_SESSION['username']) {
    die("Akses ditolak!");
}

// hapus komentar dulu
mysqli_query($conn, "DELETE FROM forum_comments WHERE post_id=$id");

// hapus post
mysqli_query($conn, "DELETE FROM forum_posts WHERE id=$id");

header("Location: forum.php");
exit;
