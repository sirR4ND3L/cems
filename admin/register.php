<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha_code']) {
        $error = "Invalid CAPTCHA code. Please try again.";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['username'], $_POST['email'], $password, $_POST['role']]);
        
        // Clear captcha after success
        unset($_SESSION['captcha_code']);
        
        header("Location: login.php"); // Send them to login after registration
        exit();
    }
}

// Generate random letters and numbers for CAPTCHA
$captcha_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | CEMS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body class="auth-body">

    <main class="auth-container">
        <div class="registration-box">
            <h1>Create Admin Account</h1>
            <p style="color: rgba(255, 255, 255, 0.8); margin-bottom: 20px;">Only authorized personnel can register.</p>
            
            <?php if (isset($error)): ?>
                <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Account Role</label>
                    <select name="role" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="Organizer">Organizer</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label>Security Verification</label>
                    <div class="captcha-wrapper">
                        <div class="captcha-code"><?php echo $captcha_code; ?></div>
                        <input type="text" name="captcha" placeholder="Type the code" required>
                    </div>
                </div>

                <button type="submit" class="btn-full">Register Account</button>
            </form>
            <p class="back-link"><a href="login.php">Back to Login</a></p>
        </div>
    </main>

</body>
</html>