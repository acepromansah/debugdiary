<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM entries WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$recentEntries = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Diary - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/debugdiary/style.css">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="app-container">
        <!-- SIDE BAR -->
        <aside class="sidebar">
            <div class="logo-app">📝 Debug Diary</div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">🏠 Home</a></li>
                    <li><a href="notes.php">📋 Tambah Catatan</a></li>
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
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            </header>

            <!-- STAT CARDS -->
            <div class="dashboard-grid">

                <div class="card-box bg-blue">
                    <h3>Total Catatan</h3>
                    <div class="value" id="totalEntries">0</div>
                </div>

                <div class="card-box bg-green">
                    <h3>Low Severity</h3>
                    <div class="value" id="lowCount">0</div>
                </div>

                <div class="card-box bg-yellow">
                    <h3>Medium Severity</h3>
                    <div class="value" id="mediumCount">0</div>
                </div>

                <div class="card-box bg-red">
                    <h3>High Severity</h3>
                    <div class="value" id="highCount">0</div>
                </div>

            </div>

            <!-- CHART & CALENDER -->
            <div class="chart-and-calendar">

                <div class="chart-section">
                    <div class="section-header">
                        <h3>Total Catatan per Bulan</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- PROFILE SECTION -->
                <div class="profile-section">

                    <h5>Profil Saya</h5>

                    <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['username']; ?>&background=random&size=128&bold=true"
                        alt="Profile" class="profile-img">

                    <h2 class="profile-name">
                        <?php echo ucfirst($_SESSION['username']); ?>
                    </h2>

                    <a href="notes.php" class="btn-profil bg-blue">
                        + Catat Bug
                    </a>
                    <a href="logout.php" onclick="return confirm('Yakin mau keluar?')" class="btn-profil bg-red">
                        Log Out
                    </a>

                </div>

            </div>

            <!-- RECENT ENTRIES TABLE -->
            <div class="recent-entries">
                <div class="section-header">
                    <h3>Recent Entries</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Catatan</th>
                                <th>Severity</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentEntries)): ?>
                                <?php foreach ($recentEntries as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['title']); ?></td>
                                        <td><span
                                                class="severity <?php echo $entry['severity']; ?>"><?php echo ucfirst($entry['severity']); ?></span>
                                        </td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($entry['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/script.js"></script>

</body>

</html>