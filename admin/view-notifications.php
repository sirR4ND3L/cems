<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM notification_log ORDER BY created_at DESC");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
$userRole = $_SESSION['admin_role'] ?? 'Organizer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">
    <nav class="navbar">
        <div class="logo">CEMS</div>

        <ul class="nav-links">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="manage-events.php">Manage Events</a></li>
            <?php if ($userRole === 'Admin'): ?>
                <li><a href="manage-users.php">Manage Users</a></li>
            <?php endif; ?>
            <li><a href="view-participants.php">View Participants</a></li>
            <li><a href="view-notifications.php" class="active">Audit Log</a></li>
            <li><a href="../api/logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="page-header">
            <h1>System Audit Log</h1>
            <p>Track all registration activities and system changes.</p>
        </div>

        <table class="data-table" style="max-width: fit-content;">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem; color: rgba(255, 255, 255, 0.5);">
                            No system activities recorded yet.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($log['event_title']); ?></td>
                        <td><span class="badge"><?php echo htmlspecialchars($log['status']); ?></span></td>
                        <td><?php echo date('M d, Y h:i A', strtotime($log['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <?php include '../includes/customAlert.php'; ?>
</body>
</html>