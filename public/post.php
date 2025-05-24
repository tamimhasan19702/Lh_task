<?php
require_once '../vendor/autoload.php';

use LH\Helpers\ConstantHelper;
use LH\Models\Blog;

ConstantHelper::initialize();

$postId = $_GET['id'] ?? null;

if (!$postId || !is_numeric($postId)) {
    header('Location: 404.php');
    exit;
}

// Load post data
$blogModel = new Blog();
$post = $blogModel->getPostById((int)$postId);

if (!$post) {
    header('Location: 404.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>

    <!-- Styles -->
    <link href="../assets/css/output.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="./assets/css/output.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons " rel="stylesheet">

    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= htmlspecialchars(strip_tags(substr($post['description'], 0, 160))) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($post['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars(strip_tags($post['description'])) ?>">
    <meta property="og:image" content="<?= BASE_URL ?>assets/images/uploads/<?= htmlspecialchars($post['image']) ?>">
    <meta property="og:type" content="article">
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-6 py-8">
        <a href="<?= BASE_URL ?>" class="text-gray-600 hover:text-gray-800 flex items-center mb-4">
            <i class="material-icons mr-2">arrow_back</i> Back to blog
        </a>

        <!-- Featured Image -->
        <img src="<?= BASE_URL ?>assets/images/uploads/<?= htmlspecialchars($post['image']) ?>"
            alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover rounded-md shadow-sm"
            loading="lazy">

        <div class="max-w-4xl mx-auto overflow-hidden">

            <!-- Post Content -->
            <div class="p-6 ">
                <h1 class="text-3xl font-bold text-gray-900 text-left"><?= htmlspecialchars($post['title']) ?></h1>
                <p class="text-sm text-gray-600 mt-2">Published on: <?= $post['created_at'] ?></p>
                <div class="mt-4 text-lg text-gray-700 whitespace-pre-line text-justify">
                    <?= nl2br(htmlspecialchars($post['description'])) ?>
                </div>
            </div>
        </div>
    </div>

    <footer
        class="py-8 px-4 flex flex-col-reverse sm:flex-row justify-between items-center text-sm text-black max-w-4xl mx-auto">
        <div class="mt-4 sm:mt-0 text-center sm:text-left">
            &copy; <?= date("Y") ?> Lemon Hive — All rights reserved.
        </div>

        <div class="flex justify-center sm:justify-end space-x-4">
            <?php if (isset($postId, $post['title'], $post['description'])): ?>
            <!-- Facebook Share -->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(BASE_URL . 'post.php?id=' . $postId) ?>"
                target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook"
                class="text-gray-500 hover:text-blue-700 transition">
                <span class="material-icons">facebook</span>
            </a>


            <?php endif; ?>
        </div>
    </footer>



</body>

</html>