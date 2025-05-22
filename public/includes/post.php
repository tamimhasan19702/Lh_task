<!-- public/post.php -->
<?php
use LH\DB;

$blogModel = new LH\Models\Blog();

$postId = $_GET['id'];
$post = $blogModel->getPostById($postId);

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
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss @2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-6 py-8">
        <div class="bg-white shadow rounded overflow-hidden">
            <img src="img/<?php echo htmlspecialchars($post['image']); ?>"
                alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-48 object-cover">
            <div class="p-4">
                <h1 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="text-gray-700"><?php echo htmlspecialchars($post['description']); ?></p>
            </div>
        </div>
    </div>
</body>

</html>