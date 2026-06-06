<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $name = trim($_POST['student_name']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($email)) {
        header("Location: ../student/student-register-event.php?id=$event_id&error=empty_fields");
        exit();
    }

    // 1. Capacity Check
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $current_registrations = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT max_capacity FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($current_registrations >= $event['max_capacity']) {
        header("Location: ../student/student-register-event.php?id=$event_id&error=event_full");
        exit();
    }

    // 2. Generate Unique Ticket ID
    $ticket_id = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));

    // 3. Register Student
    $sql = "INSERT INTO registrations (event_id, student_name, email, ticket_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$event_id, $name, $email, $ticket_id]);

    // 4. LOGGING CODE (Only happens after successful insertion)
    $reg_id = $pdo->lastInsertId();
    $log_sql = "INSERT INTO notification_log (registration_id, student_name, event_title) 
                SELECT r.id, r.student_name, e.title 
                FROM registrations r 
                JOIN events e ON r.event_id = e.id 
                WHERE r.id = ?";
    $stmt = $pdo->prepare($log_sql);
    $stmt->execute([$reg_id]);

    header("Location: ../student/registration-success.php?ticket=" . $ticket_id);
    exit();
}
?>