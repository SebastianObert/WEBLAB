<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todo_id = $_POST['todo_id'];
    $status = $_POST['status']; 

    $allowed_statuses = ['incomplete', 'in progress', 'complete', 'overdue'];
    if (!in_array($status, $allowed_statuses)) {
        header("Location: dashboard.php?message=Invalid status value.");
        exit();
    }

    $stmt = $mysqli->prepare("UPDATE tasks SET status = ? WHERE todo_id = ?");
    $stmt->bind_param('si', $status, $todo_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?message=Task status updated successfully.");
    } else {
        header("Location: dashboard.php?message=Error updating task status.");
    }
    $stmt->close();
}

$mysqli->close();
?>
