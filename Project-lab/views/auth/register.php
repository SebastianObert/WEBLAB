<?php
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkEmail = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param('s', $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo "Email sudah digunakan, silakan gunakan email lain.";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $password);
        
        if ($stmt->execute()) {
            header("Location: login.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkEmail->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% shadow-lg font-[poppins]">
        <div class="w-96 p-6 shadow-lg bg-white rounded-xl">
            <h1 class="text-3xl block text-center font-semibold"></i>Sign Up</h1>
            <hr class="mt-3">
            <div class="mt-3">
                <label for="username" class="block text-base mb-2">Nama Lengkap</label>
                <input type="text" id="username" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Nama Lengkap..." />
            </div>
            <div class="mt-3">
                <label for="username" class="block text-base mb-2">Email</label>
                <input type="text" id="username" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Email..." />
            </div>
            <div class="mt-3">
                <label for="password" class="block text-base mb-2">Password</label>
                <input type="password" id="password" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Password..." />
            </div>
            <div class="mt-5">
                <button type="submit" class="border-2 border-blue-600 bg-blue-600 text-white py-1 w-full rounded-md hover:bg-transparent hover:text-indigo-700 font-semibold transition ease-out delay-75"><i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;Register</button>
            </div>
            <div class="mt-5 grid grid-cols-3 items-center">
                <hr class="border-gray-500">
                <p class="text-center">OR</p>
                <hr class="border-gray-500">
            </div>
            <div class="mt-3 text-xs flex items-center justify-center gap-5">
                <p>Sudah Register?</p>
                <a href="login1.html">
                <button class=" py-2 px-5 border-blue-600 bg-blue-600 text-white hover:text-indigo-700 border rounded-xl hover:bg-transparent transition ease-in-out delay-75 font-semibold">Login</button>
                </a>
            </div>
        </div>
    </div>

    
    
</body>
</html>
