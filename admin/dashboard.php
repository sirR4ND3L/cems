<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
// Quick Stats Query
$totalEvents = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM registrations")->fetchColumn();

// Recent Activity: Fetch the latest event and its registration count
$latestEvent = $pdo->query("SELECT id, title FROM events ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$latestEventTitle = $latestEvent['title'] ?? 'N/A';
$latestRegCount = 0;
if ($latestEvent) {
    $regStmt = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
    $regStmt->execute([$latestEvent['id']]);
    $latestRegCount = $regStmt->fetchColumn();
}

$userRole = $_SESSION['admin_role'] ?? 'Organizer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">
    <!-- admin/dashboard.html -->
    <nav class="navbar">
        <div class="logo">CEMS</div>

        <ul class="nav-links">
            <li><a href="dashboard.php" class="active">Home</a></li>
            <li><a href="manage-events.php">Manage Events</a></li>
            <?php if ($userRole === 'Admin'): ?>
                <li><a href="manage-users.php">Manage Users</a></li>
            <?php endif; ?>
            <li><a href="view-participants.php">View Participants</a></li>
            <li><a href="view-notifications.php">Audit Log</a></li>
            <li><a href="../api/logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <h1>Overview</h1>
        
        <div class="stats-grid">
            <div class="card">
                <h3>Total Events</h3>
                <p><?php echo $totalEvents; ?></p>
            </div>
            <div class="card">
                <h3>Total Participants</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
        </div>

        <section class="form-box">
            <h2 style="color: white;">Recent Activity</h2>
            <p style="color: rgba(255, 255, 255, 0.9);">Welcome back, <strong><?php echo $userRole; ?></strong>! You have <?php echo $latestRegCount; ?> registrations for your latest event: <em style="color: #c7d2fe;">"<?php echo htmlspecialchars($latestEventTitle); ?>"</em>.</p>
            <a href="view-participants.php" class="btn">View All Participants</a>
        </section>
    </main>

</body>
</html>