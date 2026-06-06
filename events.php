<?php
require_once 'config/db.php'; // Path to your db connection
$stmt = $pdo->query("SELECT * FROM events ORDER BY date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events | CEMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
</head>
<body class="auth-body">
    <nav class="navbar">
        <div class="logo">CEMS</div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="events.php" style="color: var(--primary);">Events</a></li>
            <li><a href="about.html">About</a></li>
        </ul>
    </nav>
    <main class="container">
        <h1>Upcoming Events</h1>
        <div class="event-grid">
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <a href="student/student-register-event.php?id=<?php echo $event['id']; ?>" class="btn">Register</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>