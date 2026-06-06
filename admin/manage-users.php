<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit(); }

$stmt = $pdo->query("SELECT * FROM admins");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$userRole = $_SESSION['admin_role'] ?? 'Organizer';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | CEMS Admin</title>
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
                <li><a href="manage-users.php" class="active">Manage Users</a></li>
            <?php endif; ?>
            <li><a href="view-participants.php">View Participants</a></li>
            <li><a href="view-notifications.php">Audit Log</a></li>
            <li><a href="../api/logout.php" class="logout-link">Logout</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="page-header">
            <h1>User Management</h1>
            <p>Manage organizers and system administrators.</p>
        </div>

        <section class="form-box">
            <h2 style="color: white; margin-bottom: 25px;">Add New Organizer</h2>
            <form action="../api/add-user.php" method="POST" class="user-add-grid">
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label style="color: white;">Username</label>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label style="color: white;">Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label style="color: white;">Set Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label style="color: white;">Account Role</label>
                    <select name="role" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="Organizer">Organizer</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn" style="margin-top: 0; height: 50px; width: 100%;">Add User</button>
            </form>
        </section>

        <h2 style="margin-top: 50px; margin-bottom: 20px;">Registered Accounts</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><span class="badge"><?php echo htmlspecialchars($user['role']); ?></span></td>
                    <td>
                        <a href="#" onclick="showCustomConfirm('Remove User', 'Are you sure you want to remove this administrator?', () => window.location.href='../api/delete-user.php?id=<?php echo $user['id']; ?>')" class="btn-sm btn-delete">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <?php include '../includes/customAlert.php'; ?>
</body>
</html>