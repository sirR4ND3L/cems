<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['event_id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $max_capacity = $_POST['max_capacity'];


    $sql = "UPDATE events SET title = ?, date = ?, description = ?, max_capacity = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $date, $desc, $max_capacity, $id]);

    header("Location: ../admin/manage-events.php?status=updated");
    exit();
}
?>