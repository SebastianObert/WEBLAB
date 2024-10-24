<?php
session_start();
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expire > NOW()");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt = $mysqli->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expire = NULL WHERE reset_token = ?");
        $stmt->bind_param('ss', $new_password, $token);

        if ($stmt->execute()) {
            echo "Password berhasil direset. Silakan login dengan password baru Anda.";
        } else {
            echo "Gagal mereset password.";
        }
    } else {
        echo "Token tidak valid atau telah kedaluwarsa.";
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body>
    <div class="flex flex-col justify-center items-center h-screen bg-gradient-to-r from-indigo-500 via-sky-500 to-emerald-500 shadow-lg font-[poppins]">
        <div class="w-96 p-6 shadow-lg bg-white rounded-xl">
            <h1 class="text-3xl block text-center font-semibold">Reset Password</h1>
            <hr class="mt-3">
            <form action="" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <div class="mt-3">
                    <label for="new_password" class="block text-base mb-2">New Password</label>
                    <input type="password" name="new_password" class="border w-full text-base px-4 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-lg" placeholder="Masukkan Password Baru..." required />
                </div>
                <div class="mt-5">
                    <button type="submit" class="border-2 border-blue-600 bg-blue-600 text-white py-1 w-full rounded-md hover:bg-transparent hover:text-indigo-700 font-semibold transition ease-out delay-75">
                        <i class="fa-solid fa-key"></i>&nbsp;&nbsp;Reset Password
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
