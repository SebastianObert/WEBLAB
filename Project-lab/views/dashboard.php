<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include '../config/database.php';

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT id, title FROM todo_lists WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($todo_id, $title);
$todos = [];

while ($stmt->fetch()) {
    $todos[] = ['id' => $todo_id, 'title' => $title];
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-l from-slate-600 to-slate-800 text-white font-[poppins]">

<!-- Navbar -->
<nav class="p-4">
    <div class="container mx-auto w-10/12 flex justify-between items-center">
        <!-- Logo / Brand Name -->
        <a href="#" class="text-2xl font-bold text-indigo-400">Taskly</a>
        <!-- Navbar Links -->
        <div class="flex space-x-4">
            <a href="../logout.php" class="flex items-center border border-violet-600 bg-violet-600 hover:bg-white text-white hover:text-black px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </a>
            <a href="profile.php" class="flex items-center border border-black bg-zinc-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
                <i class="fa-solid fa-user mr-2"></i> Profile
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mx-auto mt-10 p-6">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold mb-2 ">Welcome, <span class="text-indigo-400">[Username]</span></h1>
        <p class="text-gray-400">Your personalized to-do list dashboard</p>
    </div>

    <div class="flex items-center justify-center">
    <div class=" bg-zinc-50 w-1/2 p-6 border-2 text-black border-violet-800 rounded-lg shadow-md shadow-violet-200 hover:shadow-violet-500 transition ease-in-out delay-75">
        <h2 class="text-2xl font-semibold mb-4 text-black">Your To-Do Lists</h2>
        <ul class="space-y-4">
            <!-- Jika tidak ada daftar to-do -->
            <li class="bg-zinc-100 p-4 text-center border border-black">
                No to-do lists available.
                <a href="create_todo.php" class="bg-violet-600 hover:bg-white hover:text-black text-white px-6 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
                    Create New To-Do List
                </a>
            </li>

            <!-- Contoh daftar to-do -->
            <li class="bg-zinc-100 p-4 flex justify-between items-center border border-black">
                <a href="view_tasks.php?id=1" class="text-lg font-semibold hover:text-violet-300 transition ease-in-out delay-75">Sample To-Do List 1</a>
                <button class="text-red-400 hover:text-red-600 transition ease-in-out delay-75" onclick="return confirm('Are you sure you want to delete this list?');">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </li>
            <li class="bg-zinc-100 p-4 flex justify-between items-center transition ease-in-out border border-black">
                <a href="view_tasks.php?id=2" class="text-lg hover:text-violet-300 transition ease-in-out delay-75 font-semibold">Sample To-Do List 2</a>
                <button class="text-red-400 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this list?');">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </li>
            <!-- Tambahkan daftar to-do lainnya di sini -->
        </ul>
        </div>
    </div>

    <div class="mt-6 flex justify-center gap-4">
        <a href="create_todo.php" class="bg-violet-600 hover:bg-white hover:text-black text-white px-6 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
            Create New To-Do List
        </a>
    </div>
</div>

</body>
</html>
