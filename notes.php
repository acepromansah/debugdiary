<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Verifikasi user_id valid
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    session_destroy(); // Hancurkan session palsu
    header("Location: login.php");
    exit;
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = $_POST['content'];
    $severity = $_POST['severity'];

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO entries (user_id, title, content, severity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $title, $content, $severity);
        if ($stmt->execute()) {
            $message = "success";
        } else {
            $message = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Catatan - Debug Diary</title>
  <link rel="stylesheet" type="text/css" href="/debugdiary/style.css">
</head>
<body>

    <?php if ($message): ?>
        <div style="color:<?=  strpos($message, 'berhasil') !==false ? 'green' : 'red' ?>; padding: 10px; margin: 10px;">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="app-container">
        <!-- SIDE BAR -->
        <aside class="sidebar">
            <div class="logo-app">📝 Debug Diary</div>
            <nav>
                <ul>
                    <li><a href="index.php">🏠 Home</a></li>
                    <li><a href="notes.php" class="active">📋 Tambah Catatan</a></li>
                    <li><a href="analytics.php">📊 Analytics</a></li>
                    <li><a href="forum.php">💬 Forum</a></li>
                    <li><a href="settings.php">⚙️ Settings</a></li>
                    <li><a href="#" onclick="logout()">🚪 Log Out</a></li>
                </ul>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <header class="header">
                <h1>📝 Kelola Catatan Debug</h1>
            </header>
                <form method="POST" action="">
                    <div class="form-grid">
                        <!-- JUDUL ERROR -->
                        <div class="form-field">
                            <label for="title">Judul Error</label>
                            <input type="text" id="title" name="title" placeholder="Contoh: Error di MySQL" required>
                        </div>

                        <!-- DESKRIPSI & SOLUSI -->
                        <div class="form-field full-width">
                            <label for="content">Deskripsi & Solusi</label>
                            <textarea id="content" name="content" placeholder="Jelaskan error, langkah reproduksi, dan solusi yang sudah dicoba..." required></textarea>
                        </div>

                        <!-- TINGKAT KEPARAHAN -->
                        <div class="form-field">
                        <label for="severity">Tingkat Keparahan</label>
                            <select id="severity" name="severity" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <!-- BUTTON SIMPAN -->
                        <div class="form-field full-width">
                            <button type="submit" class="btn-save">Simpan Catatan</button>
                        </div>
                    </div>
                </form>
            </div>
           

            <!-- Daftar Catatan -->
            <div id="entries" style="margin-top: 30px;"></div>
        </main> 
    </div>

    <script src="js/notes.js"></script>

</body>
</html>