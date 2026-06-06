<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Add max_capacity to the variables
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $max_capacity = $_POST['max_capacity']; // Get the capacity from the form

    // 2. Add the column and the placeholder (?) to the query
    $stmt = $pdo->prepare("INSERT INTO events (title, date, description, max_capacity) VALUES (?, ?, ?, ?)");
    
    // 3. Execute with the new variable
    $stmt->execute([$title, $date, $description, $max_capacity]);
    
    header("Location: ../admin/manage-events.php?status=success");
}
?>