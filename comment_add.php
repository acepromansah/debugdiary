<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$post_id = $_POST['post_id'];
$comment = $_POST['comment'];
$user    = $_SESSION['username'];

mysqli_query(
    $conn,
    "INSERT INTO forum_comments (post_id, username, comment)
     VALUES ('$post_id', '$user', '$comment')"
);

header("Location: forum.php");
