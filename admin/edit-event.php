<?php
session_start();
require_once '../config/db.php';
// Get the specific event ID from the URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: manage-events.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    header("Location: manage-events.php?error=event_not_found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">
    <main class="auth-container">
        <div class="registration-box" style="max-width: 500px;">
            <h1>Edit Event</h1>
            <form action="../api/edit-event.php" method="POST">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                
                <div class="form-group">
                    <label>Event Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Date</label>
                    <input type="datetime-local" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['date'])); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"><?php echo htmlspecialchars($event['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Maximum Capacity</label>
                    <input type="number" name="max_capacity" value="<?php echo htmlspecialchars($event['max_capacity']); ?>" min="1" required>
                </div>

                <button type="submit" class="btn-full">Update Event</button>
            </form>
            <p class="back-link">
                <a href="manage-events.php" style="color: #ddd;">← Back to Manage</a>
            </p>
        </div>
    </main>
</body>
</html>