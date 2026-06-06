<?php
require_once '../config/db.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: ../admin/manage-users.php");
exit();
?>