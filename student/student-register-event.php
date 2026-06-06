<?php
require_once '../config/db.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Event not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">

    <main class="auth-container">
        <div class="registration-box">
            <h1>Register for Event</h1>
            
            <?php if (isset($_GET['error']) && $_GET['error'] == 'event_full'): ?>
                <div style="background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #fecaca;">
                    <strong>Registration Failed:</strong> This event is currently full.
                </div>
            <?php endif; ?>

            <p class="event-name">Joining: <strong><?php echo htmlspecialchars($event['title']); ?></strong></p>
            
            <form action="../api/register-student.php" method="POST">
                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="student_name" required>
                </div>
                <div class="form-group">
                    <label>University Email</label>
                    <input type="email" name="email" required>
                </div>
                <button type="submit" class="btn-full">Confirm Registration</button>
            </form>
            <p class="back-link"><a href="../index.php">← Back to events</a></p>
        </div>
    </main>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.querySelector('input[type="email"]').value;
            if (!email.includes('@')) {
                e.preventDefault();
                alert("Please enter a valid email address.");
            }
        });
    </script>

</body>
</html>