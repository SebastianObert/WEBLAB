<?php
session_start();
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $reset_token = bin2hex(random_bytes(16));
        $reset_token_expire = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $stmt = $mysqli->prepare("UPDATE users SET reset_token = ?, reset_token_expire = ? WHERE email = ?");
        $stmt->bind_param('sss', $reset_token, $reset_token_expire, $email);
        
        if ($stmt->execute()) {
            $reset_link = "http://localhost/Project-lab/views/auth/reset_password.php?token=" . $reset_token;
            $subject = "Reset Password";
            $message = "Klik tautan ini untuk mereset password Anda: " . $reset_link;
            mail($email, $subject, $message); 
            echo "Tautan reset password telah dikirim ke email Anda.";
        } else {
            echo "Gagal menyimpan token.";
        }
    } else {
        echo "Email tidak ditemukan.";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
    <div class="flex flex-col justify-center items-center h-screen bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-500 shadow-lg font-[poppins]">
        <div class="w-96 p-6 shadow-lg bg-white rounded-xl">
            <h1 class="text-3xl block text-center font-semibold">Forgot Password</h1>
            <hr class="mt-3">
            <form action="" method="POST">
                <div class="mt-3">
                    <label for="email" class="block text-base mb-2">Email</label>
                    <input type="email" name="email" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Email..." required />
                </div>
                <div class="mt-5">
                    <button type="submit" class="border-2 border-blue-600 bg-blue-600 text-white py-1 w-full rounded-md hover:bg-transparent hover:text-indigo-700 font-semibold transition ease-out delay-75">
                        <i class="fa-solid fa-paper-plane"></i>&nbsp;&nbsp;Kirim Tautan Reset
                    </button>
                </div>
            </form>
            <div class="mt-3 text-xs text-center">
                <a href="login.php" class="text-blue-600">Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>
</html>
