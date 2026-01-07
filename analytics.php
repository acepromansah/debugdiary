<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Debug Diary</title>
    <link rel="stylesheet" type="text/css" href="/debugdiary/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="app-container">
        <!-- SIDE BAR -->
        <aside class="sidebar">
            <div class="logo-app">📝 Debug Diary</div>
            <nav>
                <ul>
                    <li><a href="index.php">🏠 Home</a></li>
                    <li><a href="notes.php">📋 Tambah Catatan</a></li>
                    <li><a href="analytics.php" class="active">📊 Analytics</a></li>
                    <li><a href="forum.php">💬 Forum</a></li>
                    <li><a href="settings.php">⚙️ Settings</a></li>
                    <li><a href="#" onclick="logout()">🚪 Log Out</a></li>
                </ul>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <header class="header">
                <h1>📊 Analisis Catatan</h1>
            </header>

            <div class="charts-side-by-side">
                <div class="chart-wrapper">
                    <div class="chart-canvas">
                        <canvas id="severityChart"></canvas>
                    </div>
                </div>

                <div class="chart-wrapper">
                    <div class="chart-title">Total Catatan per Bulan</div>
                    <div class="chart-canvas">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/analytics.js"></script>
</body>
</html>