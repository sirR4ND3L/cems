<?php
require_once '../config/db.php';
session_start();

// Ensure only authorized staff can delete
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM registrations WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header("Location: ../admin/view-participants.php?status=removed");
exit();
?>