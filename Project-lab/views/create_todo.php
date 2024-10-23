<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $color = $_POST['color'];
    $user_id = $_SESSION['user_id'];

    if (!empty($title)) {
        $sql = "INSERT INTO todo_lists (user_id, title, description, due_date, priority, color) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isssss", $user_id, $title, $description, $due_date, $priority, $color);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error creating to-do list.";
        }
    } else {
        $error = "Title cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create To-Do List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-l from-slate-600 to-slate-800 text-white font-[Poppins]">

<div class="container mx-auto mt-10 p-6 max-w-lg bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-center text-indigo-400">Create New To-Do List</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium mb-2">Title:</label>
            <input type="text" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" id="title" name="title" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium mb-2">Description:</label>
            <textarea class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" id="description" name="description" rows="4" placeholder="Enter a brief description..."></textarea>
        </div>
        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium mb-2">Due Date:</label>
            <input type="date" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" id="due_date" name="due_date">
        </div>
        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium mb-2">Priority Level:</label>
            <select class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" id="priority" name="priority">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="color" class="block text-sm font-medium mb-2">Color:</label>
            <input type="color" class="w-full p-0" id="color" name="color" value="#ffffff">
        </div>
        <button type="submit" class="w-full bg-violet-600 hover:bg-white hover:text-black text-white py-2 rounded-md font-semibold transition ease-in-out delay-75">Create</button>
        <a href="dashboard.php" class="w-full bg-gray-700 text-white py-2 rounded-md text-center block mt-2 hover:bg-gray-600 transition ease-in-out delay-75">Cancel</a>
    </form>
</div>

</body>
</html>
