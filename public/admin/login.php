<?php
require '../../vendor/autoload.php';

use LH\Helpers\ConstantHelper;
use LH\Helpers\ImageHelper;

ConstantHelper::initialize();

session_start();

// Check if the user is already authenticated
if (isset($_SESSION['authenticated'])) {
    // User is already logged in
    $error = 'You are already logged in.';
} else {
    // Handle login submission
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username === 'lemon' && $password === 'lemon') {
            $_SESSION['authenticated'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../assets/css/output.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat :wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans text-gray-800">
    <?php include '../includes/header.php'; ?>

    <div class="flex items-center justify-center h-screen">
        <div class="max-w-sm w-full space-y-8">
            <div class="text-center flex justify-center">
                <a href="<?= BASE_URL ?>" class="text-xl font-bold text-gray-800">
                    <?php
                    $logoPath = ImageHelper::getImagePath('logo.png');
                    if ($logoPath !== null) {
                        echo "<img src='$logoPath' alt='Logo'>";
                    } else {
                        echo "<span class='text-red-500'>Logo not found</span>";
                    }
                    ?>
                </a>
            </div>

            <?php if (isset($error)): ?>
            <!-- Display error message -->
            <div class="text-center text-red-500">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            <!-- Show login form -->
            <form action="" method="POST" class="mt-8 space-y-6">
                <input type="hidden" name="csrf_token" value="your_csrf_token_here">

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">
                        Username
                    </label>
                    <div class="mt-1">
                        <input id="username" name="username" type="text" required autofocus autocomplete="username"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit" name="login"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-700">
                        Sign in
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>