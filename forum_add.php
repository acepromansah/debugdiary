<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$title   = $_POST['title'];
$content = $_POST['content'];
$user    = $_SESSION['username'];

$query = "INSERT INTO forum_posts (username, title, content)
          VALUES ('$user', '$title', '$content')";

mysqli_query($conn, $query);

header("Location: forum.php");
