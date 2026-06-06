<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">

    <nav class="navbar">
        <div class="logo">CEMS</div>
        <ul class="nav-links">
            <li><a href="../index.php">Events</a></li>
            <li><a href="my-registrations.php">My Ticket</a></li>
        </ul>
    </nav>
    
    <main class="auth-container">
        <div class="registration-box">
            <h1>Registration Successful!</h1>
            <p>You have been registered for the event.</p>
            <a href="check-registration.php?email=<?php echo urlencode($_POST['email'] ?? ''); ?>" class="btn">View My Ticket</a>
            <a href="../index.php" class="btn">Back to Home</a>
        </div>
    </main>

</body>
</html>