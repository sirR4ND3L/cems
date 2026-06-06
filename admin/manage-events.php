<?php
session_start();
require_once '../config/db.php';
$stmt = $pdo->query("SELECT * FROM events ORDER BY date ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
$userRole = $_SESSION['admin_role'] ?? 'Organizer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">

    <!-- admin/dashboard.html -->
    <nav class="navbar">
        <div class="logo">CEMS</div>

        <ul class="nav-links">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="manage-events.php" class="active">Manage Events</a></li>
            <?php if ($userRole === 'Admin'): ?>
                <li><a href="manage-users.php">Manage Users</a></li>
            <?php endif; ?>
            <li><a href="view-participants.php">View Participants</a></li>
            <li><a href="view-notifications.php">Audit Log</a></li>
            <li><a href="../api/logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <h1>Event Management</h1>

        <section class="form-box" style="margin-bottom: 40px;">
            <h2>Create New Event</h2>
            <form action="../api/create-event.php" method="POST">
                <div class="form-group"><label style="color: white;">Event Title</label><input type="text" name="title" required></div>
                <div class="form-group"><label style="color: white;">Date & Time</label><input type="datetime-local" name="date" required></div>
                <div class="form-group"><label style="color: white;">Description</label><textarea name="description"></textarea></div>
                <div class="form-group"><label style="color: white;">Maximum Capacity</label><input type="number" name="max_capacity" value="255" min="0" required></div>
                <button type="submit" class="btn">Publish Event</button>
            </form>
        </section>

        <h2>Existing Events</h2>
        <div class="form-group" style="margin-bottom: 25px;">
            <input type="text" id="searchBar" onkeyup="filterEvents()" placeholder="Search events by title...">
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><?php echo htmlspecialchars($event['date']); ?></td>
                    <td class="table-actions">
                        <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="btn-sm btn-edit">Edit</a>
                        <button class="btn-sm btn-delete" onclick="deleteEvent('<?php echo $event['id']; ?>', this.closest('tr'))">Delete</button>
                        <button class="btn-sm btn-share" onclick="copyLink('<?php echo $event['id']; ?>')">Share Link</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <?php include '../includes/customAlert.php'; ?>
</body>
</html>