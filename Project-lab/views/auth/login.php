<?php
session_start();
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: ../dashboard.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }

    $stmt->close();
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
    <div class="flex flex-col justify-center items-center h-screen bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% shadow-lg font-[poppins]">
        <h1 class="text-4xl font-bold mb-6 text-white"><span class="auto-type"></span></h1> 
        <div class="w-96 p-6 shadow-lg bg-white rounded-xl">
            <h1 class="text-3xl block text-center font-semibold"><i class="fa-solid fa-user"></i> Sign In</h1>
            <hr class="mt-3">
            <div class="mt-3">
                <label for="username" class="block text-base mb-2">Username</label>
                <input type="text" id="username" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Username..." />
            </div>
            <div class="mt-3">
                <label for="password" class="block text-base mb-2">Password</label>
                <input type="password" id="password" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Password..." />
            </div>
            <div class="mt-5">
                <button type="submit" class="border-2 border-blue-600 bg-blue-600 text-white py-1 w-full rounded-md hover:bg-transparent hover:text-indigo-700 font-semibold transition ease-out delay-75"><i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;Login</button>
            </div>
            <div class="mt-5 grid grid-cols-3 items-center">
                <hr class="border-gray-500">
                <p class="text-center">OR</p>
                <hr class="border-gray-500">
            </div>
            <div class="mt-3 text-xs flex items-center justify-center gap-5">
                <p>Belum punya akun?</p>
                <a href="login2.html">
                    <button class="py-2 px-5 border-blue-600 bg-blue-600 text-white hover:text-indigo-700 border rounded-xl hover:bg-transparent transition ease-in-out delay-75">Register</button>
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        var typed = new Typed(".auto-type" , {
            strings : 
                    ["Selamat Datang di Taskly",
                    "Kelola tugas harian Anda dengan mudah dan teratur",
                    "Tetap produktif dengan daftar tugas yang selalu terupdate",
                    "Sederhanakan rencana harian Anda dan capai lebih banyak",
                    ],   
            typeSpeed: 50,      
            backSpeed: 10,      
            loop: true,        
            startDelay: 500,    
            backDelay: 1000,    
        })
    </script>
    
</body>
</html>

