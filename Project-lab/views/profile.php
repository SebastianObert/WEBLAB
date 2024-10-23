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

<nav class="p-4">
    <div class="container mx-auto w-10/12 flex justify-between items-center">
        <a href="#" class="text-2xl font-bold text-indigo-400">Dailyze</a>
        <div class="flex space-x-4">
            <a href="../dashboard.php" class="flex items-center border border-violet-600 bg-violet-600 hover:bg-white text-white hover:text-black px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
               <i class="fa-solid fa-home mr-2"></i> Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container mx-auto mt-5 p-6">
    <div class="bg-gray-800 border-2 border-violet-600 p-8 rounded-lg shadow-lg max-w-lg mx-auto shadow-violet-600 hover:shadow-violet-900 transition ease-in-out delay-100">
        <h2 class="text-3xl font-bold mb-6 text-center text-indigo-400">Profile</h2>
        <div class="mb-4">
            <p class="text-lg"><strong>Username:</strong> <?php echo htmlspecialchars($username, ENT_QUOTES); ?></p>
        </div>
        <div class="mb-4">
            <p class="text-lg"><strong>Email:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES); ?></p>
        </div>
        <div class="flex justify-between mt-6">
            <a href="edit_profile.php" class="bg-violet-600 hover:bg-white hover:text-black text-white py-2 px-6 rounded-md font-semibold transition ease-in-out delay-75">Edit Profile</a>
            <a href="dashboard.php" class="bg-gray-700 hover:bg-white hover:text-black text-white py-2 px-6 rounded-md font-semibold transition ease-in-out delay-75">Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
