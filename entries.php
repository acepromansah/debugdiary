<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Diary - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/debugdiary/style.css">
</head>
<body>
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
                                <td><span class="severity <?php echo $entry['severity']; ?>"><?php echo ucfirst($entry['severity']); ?></span></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($entry['created_at']));?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/script.js"></script>
    
</body>
</html>