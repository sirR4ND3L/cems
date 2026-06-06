<?php
require_once 'config/db.php';

$today = date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM events WHERE date >= ? ORDER BY date ASC");
$stmt->execute([$today]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
</head>
<body class="auth-body">

    <nav class="navbar">
        <div class="logo">CEMS</div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="admin/login.php" class="admin-link">Staff Login</a></li>
        </ul>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Campus Events Hub</h1>
            <p>Discover and register for upcoming activities</p>
            <div style="margin-top: 40px;">
                <a href="student/check-registration.php" class="btn btn-hero">View My Registered Events</a>
            </div>
        </div>
    </header>

    <main class="container">
        <h2 style="margin-bottom: 40px; font-weight: 800; font-size: 2.2rem; letter-spacing: -0.03em;">Available Events</h2>
            <?php if (empty($events)): ?>
                <div style="text-align: center; width: 100%; padding: 40px 20px; color: rgba(255, 255, 255, 0.6);">
                    <h3 style="font-size: 1.6rem; margin-bottom: 10px; color: rgba(255, 255, 255, 0.9);">No upcoming events</h3>
                    <p style="font-size: 1.1rem;">Please check back later for new activities!</p>
                </div>
            <?php else: ?>
                <div class="event-grid">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <h3 style="color: var(--primary); font-size: 1.4rem; margin-bottom: 15px;"><?php echo htmlspecialchars($event['title']); ?></h3>
                        <p style="margin-bottom: 8px;"><strong>Date:</strong> <?php echo date('M d, Y | h:i A', strtotime($event['date'])); ?></p>
                        <p style="opacity: 0.8; margin-bottom: 25px; min-height: 3em;"><?php echo htmlspecialchars(mb_strimwidth($event['description'], 0, 120, "...")); ?></p>
                        <a href="student/student-register-event.php?id=<?php echo $event['id']; ?>" 
                           class="btn" 
                           style="width: 100%; text-align: center;"
                           aria-label="Register for <?php echo htmlspecialchars($event['title']); ?>">
                           Register
                        </a>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
    </main>

    <?php include 'includes/customAlert.php'; ?>
</body>
</html>