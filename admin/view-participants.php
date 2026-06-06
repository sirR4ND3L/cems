<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$events = $pdo->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);
$userRole = $_SESSION['admin_role'] ?? 'Organizer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Participants | CEMS</title>
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
            <li><a href="view-participants.php" class="active">View Participants</a></li>
            <li><a href="view-notifications.php">Audit Log</a></li>
            <li><a href="../api/logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <h1>Participant Logs by Event</h1>

        <?php foreach ($events as $event): ?>
            <details class="event-accordion">
                <summary>Event: <?php echo htmlspecialchars($event['title']); ?></summary>
                
                <table class="data-table">
                    <thead>
                        <tr><th>Student Name</th><th>Email</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stmt = $pdo->prepare("SELECT * FROM registrations WHERE event_id = ?");
                        $stmt->execute([$event['id']]);
                        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($participants as $p): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($p['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($p['email']); ?></td>
                                <td>
                                    <a href="#" 
                                    class="btn-sm btn-delete" 
                                    onclick="showCustomConfirm('Remove Participant', 'Are you sure you want to remove this student from the event?', () => window.location.href='../api/delete-registration.php?id=<?php echo $p['id']; ?>')">
                                    Remove
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </details>
        <?php endforeach; ?>
    </main>
    <?php include '../includes/customAlert.php'; ?>
</body>
</html>