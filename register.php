<?php
    require 'koneksi.php';

    $register_message = "";

    if (isset ($_POST["register"])) {
        $username = $_POST["username"];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash ($_POST['password'],PASSWORD_DEFAULT);

        $query_sql = "INSERT INTO users (username, name, email, password) VALUES
        ('$username', '$name', '$email', '$password')";

        if ($conn->query($query_sql)) {
            header ("Location: login.html");
        } else {
            echo "Pendaftaran Gagal";
        }
    }
