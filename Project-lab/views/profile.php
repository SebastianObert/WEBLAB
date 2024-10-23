<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include '../config/database.php';

$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-l from-slate-600 to-slate-800 text-white">

<!-- Navbar -->
<nav class="p-4">
    <div class="container mx-auto w-10/12 flex justify-between items-center">
        <!-- Logo / Brand Name -->
        <a href="#" class="text-2xl font-bold text-indigo-400">Taskly</a>
        <!-- Navbar Links -->
        <div class="flex space-x-4">
            <a href="../dashboard.php" class="flex items-center border border-violet-600 bg-violet-600 hover:bg- hover:bg-white text-white hover:text-black px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
               <i class="fa-solid fa-home mr-2"></i> Dashboard
            </a>
        </div>
    </div>
</nav>

<!-- Profile Update Form -->
<div class="container mx-auto mt-5 p-6">
    <div class="bg-gray-800 border-2 border-violet-600 p-8 rounded-lg shadow-lg max-w-lg mx-auto shadow-violet-600 hover:shadow-violet-900 transition ease-in-out delay-100">
        <h2 class="text-3xl font-bold mb-6 text-center text-indigo-400">Update Profile</h2>
        <form action="update_profile.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium mb-2">Nama Lengkap</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan Nama Lengkap">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan Email">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-2">New Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan Password Baru">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium mb-2">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Konfirmasi Password Baru">
            </div>
            <button type="submit" class="w-full bg-violet-600 hover:bg-white hover:text-black text-white py-2 rounded-md font-semibold transition ease-in-out delay-75">Update Profile</button>
        </form>
    </div>
</div>

</body>
</html>