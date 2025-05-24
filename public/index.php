<?php

require_once '../vendor/autoload.php'; 

use LH\DB;
use LH\Models\Blog;
use LH\Helpers\ConstantHelper;

ConstantHelper::initialize();



$blogModel = new Blog();

$postsPerPage = $blogModel->getPostsPerPage();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $postsPerPage;

$posts = $blogModel->getAllPosts($postsPerPage, $offset);
$totalPosts = $blogModel->getTotalPosts(); // Use total posts for pagination

$paginationLinks = '';
$totalPages = ceil($totalPosts / $postsPerPage);

for ($i = 1; $i <= $totalPages; $i++) {
    $active = ($i === $page) ? 'bg-white text-primary' : 'text-gray-600 hover:bg-primary hover:text-white';
    $paginationLinks .= "<a href='?page=$i' class='px-4 py-2 rounded $active'>$i</a>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <link href="./assets/css/output.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat :wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold mb-4">Blog Posts</h1>

        <?php if (empty($posts)): ?>
        <p class="text-gray-600">No blog posts found.</p>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($posts as $post): ?>
            <div class="bg-white shadow rounded overflow-hidden">
                <img src="<?= BASE_URL . 'assets/images/uploads/' . htmlspecialchars($post['image']); ?>"
                    alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2"><a
                            href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                    </h2>
                    <p class="text-gray-700 line-clamp-3">
                        <?php
                        $description = htmlspecialchars($post['description']);
                        $limitedDescription = substr($description, 0, 50) . (strlen($description) > 50 ? '...' : '');
                        echo $limitedDescription;
                        ?>
                    </p>
                    <a href="post.php?id=<?php echo $post['id']; ?>"
                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Read
                        More</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="mt-8 flex justify-center">
            <?php echo $paginationLinks; ?>
        </div>
    </div>
</body>

</html>