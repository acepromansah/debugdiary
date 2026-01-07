<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

$post = mysqli_query($conn, "SELECT * FROM forum_posts WHERE id=$id");
$data = mysqli_fetch_assoc($post);

if (!$data || $data['username'] !== $_SESSION['username']) {
    die("Akses ditolak!");
}

// hapus catatan
mysqli_query($conn, "DELETE FROM entries WHERE post_id=$id");

header("Location: forum.php");
exit;
