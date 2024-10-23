<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todo_id = $_POST['todo_id']; 

    $stmt = $mysqli->prepare("DELETE FROM todo_lists WHERE id = ? AND user_id = ?");
    $stmt->bind_param('ii', $todo_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?message=To-do list deleted successfully.");
    } else {
        header("Location: dashboard.php?message=Error deleting to-do list.");
    }
    $stmt->close();
}

$mysqli->close();
