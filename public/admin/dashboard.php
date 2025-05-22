<?php

require '../../vendor/autoload.php';

use LH\Helpers\ConstantHelper;
use LH\Helpers\ImageHelper;

ConstantHelper::initialize();

session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';
$blogModel = new LH\Models\Blog();

$posts = $blogModel->getAllPosts(10, 0); // Fetch 10 posts
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../assets/css/output.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat :wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold mb-4">Blog Posts</h1>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="edit-post.php?id=<?php echo $post['id']; ?>"
                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <a href="#" onclick="deletePost(<?php echo $post['id']; ?>)"
                            class="text-red-600 hover:text-red-900 ml-2">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    function deletePost(id) {
        if (confirm('Are you sure you want to delete this post?')) {
            fetch(`delete-post.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Post deleted successfully');
                        location.reload();
                    } else {
                        alert('Failed to delete post');
                    }
                });
        }
    }
    </script>
</body>

</html>