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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-500 shadow-lg font-[poppins]">
        <div class="w-96 p-6 shadow-lg bg-white rounded-xl">
            <h1 class="text-3xl block text-center font-semibold">Sign Up</h1>
            <hr class="mt-3">

            <form action="register.php" method="POST">
                <div class="mt-3">
                    <label for="username" class="block text-base mb-2">Nama Lengkap</label>
                    <input type="text" name="username" class="border w-full text-base px-4 py-2 rounded-lg" placeholder="Masukkan Nama Lengkap..." required />
                </div>
                <div class="mt-3">
                    <label for="email" class="block text-base mb-2">Email</label>
                    <input type="email" name="email" class="border w-full text-base px-4 py-2 rounded-lg" placeholder="Masukkan Email..." required />
                </div>
                <div class="mt-3">
                    <label for="password" class="block text-base mb-2">Password</label>
                    <input type="password" name="password" class="border w-full text-base px-4 py-2 rounded-lg" placeholder="Masukkan Password..." required />
                </div>
                <div class="mt-5">
                    <button type="submit" class="border-2 border-blue-600 bg-blue-600 text-white py-1 w-full rounded-md hover:bg-transparent hover:text-indigo-700">Register</button>
                </div>
            </form>

            <div class="mt-5 grid grid-cols-3 items-center">
                <hr class="border-gray-500">
                <p class="text-center">OR</p>
                <hr class="border-gray-500">
            </div>
            <div class="mt-3 text-xs flex items-center justify-center gap-5">
                <p>Sudah Register?</p>
                <a href="login.php">
                    <button class="py-2 px-5 border-blue-600 bg-blue-600 text-white hover:text-indigo-700 border rounded-xl">Login</button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
