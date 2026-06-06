<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and capture inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'] ?? 'default123';

    if (empty($name) || empty($email) || empty($role) || empty($password)) {
        header("Location: ../admin/manage-users.php?status=error");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the admins table
    $sql = "INSERT INTO admins (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $hashed_password, $role]);

    // Redirect back to the user management page
    header("Location: ../admin/manage-users.php?status=user_added");
    exit();
}
?>