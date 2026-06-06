<?php
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM registrations WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

// Redirect back to the list
header("Location: ../student/my-registrations.php?email=" . urlencode($_GET['email'] ?? ''));
exit();
?>