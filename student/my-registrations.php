<?php
require_once '../config/db.php';
// Check if email was provided via the search form
if (!isset($_GET['email']) || empty($_GET['email'])) {
    header("Location: check-registration.php?error=empty");
    exit();
}

$email = $_GET['email'] ?? ''; 

$stmt = $pdo->prepare("SELECT registrations.*, events.title, events.date 
                       FROM registrations 
                       JOIN events ON registrations.event_id = events.id 
                       WHERE registrations.email = ?");
$stmt->execute([$email]);
$my_tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Registrations | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">
    
    <nav class="navbar">
        <div class="logo">CEMS</div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="check-registration.php" class="active">My Ticket</a></li>
            <li><a href="../about.html">About</a></li>
        </ul>
    </nav>

    <main class="auth-container">
        <div class="registration-box" style="max-width: 600px;">
            <h1>My Event Receipts</h1>
            <p style="margin-bottom: 20px;">Tickets for: <strong><?php echo htmlspecialchars($email); ?></strong></p>

            <?php if (empty($my_tickets)): ?>
                <div class="receipt-card">
                    <p>No active registrations found for this email address.</p>
                    <a href="check-registration.php" class="btn">Search Again</a>
                </div>
            <?php else: ?>
            <?php foreach ($my_tickets as $ticket): ?>
                <div class="receipt-card">
                    <div class="ticket-header" style="display: flex; justify-content: space-between;">
                        <p><strong>Event:</strong> <?php echo htmlspecialchars($ticket['title']); ?></p>
                        <span class="ticket-badge">
                            <?php echo htmlspecialchars($ticket['ticket_id']); ?>
                        </span>
                    </div>
                    
                    <p><strong>Event Date:</strong> <?php echo date('M d, Y h:i A', strtotime($ticket['date'])); ?></p>
                    <p style="font-size: 0.9rem; opacity: 0.8;">
                        <strong>Registered on:</strong> <?php echo date('M d, Y h:i A', strtotime($ticket['registration_date'])); ?>
                    </p>
                    
                    <div class="button-group">
                        <a href="#" 
                        onclick="showCustomConfirm('Cancel Registration', 'Are you sure?', () => window.location.href='../api/cancel-registration.php?id=<?php echo $ticket['id']; ?>')" 
                        class="btn btn-delete">Cancel Participation</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../includes/customAlert.php'; ?>
</body>
</html>