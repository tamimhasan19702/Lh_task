<?php
require_once '../../vendor/autoload.php';

session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

use LH\Helpers\ConstantHelper;
use LH\Models\Blog;
-
ConstantHelper::initialize();

$blogModel = new Blog();
$postsPerPage = $blogModel->getPostsPerPage();

if (isset($_POST['posts_per_page'])) {
    $newPostsPerPage = (int)$_POST['posts_per_page'];
    $blogModel->updatePostsPerPage($newPostsPerPage);
    header('Location: settings.php?success=true&message=Posts per page updated successfully');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="../assets/css/output.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons " rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans text-gray-800">
    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto px-6 py-8">
        <a href="<?= BASE_URL ?>/admin/dashboard.php" class="text-gray-600 hover:text-gray-800 flex items-center mb-4">
            <i class="material-icons mr-2">arrow_back</i> Back to dashboard
        </a>

        <h2 class="text-xl font-bold mb-6">Number of posts per page</h2>

        <!-- Success/Error Message -->
        <?php if (isset($_GET['success'])): ?>
        <div
            class="<?= $_GET['success'] === 'true' ? 'bg-green-100' : 'bg-red-100' ?> border-l-4 <?= $_GET['success'] === 'true' ? 'border-green-500 text-green-700' : 'border-red-500 text-red-700' ?> p-4 mb-6">
            <p><?= htmlspecialchars(urldecode($_GET['message'])); ?></p>
        </div>
        <script>
        setTimeout(() => document.querySelector('.bg-green-100, .bg-red-100').remove(), 3000);
        </script>
        <?php endif; ?>


        <!-- Posts Per Page Setting -->
        <form method="POST" class="mb-8">
            <label for="posts_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                Number of posts per page
            </label>
            <input type="number" id="posts_per_page" name="posts_per_page" min="1" max="100"
                value="<?php echo $postsPerPage; ?>"
                class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Enter the number of posts per page">

            <button type="submit"
                class="mt-4 bg-primary text-white px-4 py-2 rounded-md hover:bg-dark-primary transition duration-300">
                Save Settings
            </button>
        </form>
    </div>
</body>

</html>