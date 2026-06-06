<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find My Registration | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">

    <main class="auth-container">
        <div class="registration-box">
            <h1>View My Tickets</h1>
            <p>Enter your registration email to view or cancel your event participation.</p>
            
            <form action="my-registrations.php" method="GET">
                <div class="form-group">
                    <label>University Email</label>
                    <input type="email" name="email" placeholder="example@student.edu" required>
                </div>
                <button type="submit" class="btn-full">View My Tickets</button>
            </form>
            
            <p class="back-link">
                <a href="../index.php">← Back to Home</a>
            </p>
        </div>
    </main>

</body>
</html>