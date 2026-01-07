<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM forum_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Diary - Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app-container">

    <!-- SIDEBAR (SAMA PERSIS) -->
    <aside class="sidebar">
        <div class="logo-app">📝 Debug Diary</div>
        <nav>
            <ul>
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="notes.php">📋 Tambah Catatan</a></li>
                <li><a href="analytics.php">📊 Analytics</a></li>
                <li><a href="forum.php" class="active">💬 Forum</a></li>
                <li><a href="settings.php">⚙️ Settings</a></li>
                <li><a href="#" onclick="logout()">🚪 Log Out</a></li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER (SAMA STYLE) -->
        <header class="header">
            <h1>💬 Forum Diskusi</h1>
            <div class="header-right">
                <div class="user-avatar">👤</div>
            </div>
        </header>

        <!-- BUAT POST -->
        <div class="card">
            <h3>✏️ Buat Diskusi Baru</h3>
            <form action="forum_add.php" method="POST">
                <input type="text" name="title" placeholder="Judul diskusi" required>
                <textarea name="content" placeholder="Tulis isi diskusi..." required></textarea>
                <button type="submit" class="btn-primary"> 📤 Posting</button>
            </form>
        </div>

        <!-- LIST POST -->
        <div class="card">
            <h3>🔥 Diskusi Terbaru</h3>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="forum-post">

                    <div class="post-header">
                    <h4>💬 <?= htmlspecialchars($row['title']) ?></h4>
                    <?php if ($_SESSION['username'] === $row['username']) { ?>
                    <a href="forum_delete.php?id=<?= $row['id'] ?>"class="btn-delete"
                    onclick="return confirm('Yakin ingin menghapus diskusi ini?')">🗑️ Hapus
                    </a>
                    <?php } ?>
                    </div>


                    <small>
                        👤 <b><?= htmlspecialchars($row['username']) ?></b>
                        • ⏰ <?= $row['created_at'] ?>
                    </small>

                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                    <!-- KOMENTAR -->
                    <?php
                    $comments = mysqli_query(
                        $conn,
                        "SELECT * FROM forum_comments 
                         ORDER BY created_at ASC"
                    );
                    ?>

                    <div class="forum-comments">
                        <h5>💭 Balasan</h5>

                        <?php while ($c = mysqli_fetch_assoc($comments)) { ?>
                            <div class="comment">
                                <b>👤 <?= htmlspecialchars($c['username']) ?></b>
                                <small>⏰ <?= $c['created_at'] ?></small>
                                <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                            </div>
                        <?php } ?>

                        <!-- FORM BALAS -->
                        <form action="comment_add.php" method="POST" class="comment-form">
                            <input type="hidden" name="post_id" value="<?= $row['id'] ?>">
                            <textarea name="comment" placeholder="Tulis balasan..." required></textarea>
                            <button type="submit">↩️ Balas</button>
                        </form>
                    </div>

                </div>
                <hr>
            <?php } ?>

        </div>

    </main>
</div>

<script>
            /* animasi menu sidebar */
        document.querySelectorAll('.sidebar nav a').forEach(link => {
        link.addEventListener('click', function (e) {

        // kalau link masih #
        if (this.getAttribute('href') === '#') {
            e.preventDefault();
        }

        document.querySelectorAll('.sidebar nav a')
            .forEach(l => l.classList.remove('active'));

        this.classList.add('active');
    });
});
</script>


<script>
function logout() {
    if (confirm("Yakin ingin keluar?")) {
        window.location.href = "logout.php";
    }
}
</script>

</body>
</html>

