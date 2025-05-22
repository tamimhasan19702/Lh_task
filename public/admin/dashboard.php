<?php
require '../../vendor/autoload.php';

session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

use LH\Helpers\ConstantHelper;
use LH\Helpers\ImageHelper;
use LH\Models\Blog;
use LH\DB;

ConstantHelper::initialize();

$blogModel = new Blog();
$posts = $blogModel->getAllPosts(10,0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="../assets/css/output.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons " rel="stylesheet">
    <style>
    .hidden-on-mobile {
        display: table-cell;
    }

    @media (max-width: 640px) {
        .hidden-on-mobile {
            display: none;
        }
    }
    </style>
</head>

<body class="bg-gray-100 font-sans text-gray-800">
    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto px-4 py-8">

        <a href="<?= BASE_URL ?>/admin/dashboard.php" class="text-gray-600 hover:text-gray-800 flex items-center">
            <i class="material-icons mr-2">arrow_back</i> Back to dashboard
        </a>
        <!-- Back & Create -->
        <div class="flex mt-6 flex-row  justify-between items-center mb-6 space-y-4 sm:space-y-0">

            <h1 class="text-xl sm:text-2xl font-bold">Published Blog List</h1>
            <div class="flex space-x-2">
                <a href="<?= BASE_URL ?>/admin/create-post.php"
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-dark-primary transition duration-300 flex items-center">
                    <i class="material-icons mr-2">add</i>
                    <span class="hidden sm:inline">Create new post</span>
                </a>
                <a href="<?= BASE_URL ?>/admin/settings.php"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 flex items-center">
                    <i class="material-icons mr-2">settings</i>
                    <span class="hidden sm:inline">Settings</span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <div id="alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>Post created successfully!</p>
        </div>
        <script>
        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 2000);
        </script>
        <?php endif; ?>

        <!-- Responsive Blog List -->
        <div class="space-y-4 sm:hidden">
            <?php foreach ($posts as $post): ?>
            <div id="post-card-<?php echo $post['id']; ?>" class="bg-white shadow rounded-lg p-4">
                <h3 class="font-bold text-lg"><?php echo htmlspecialchars($post['title']); ?></h3>
                <p class="text-sm text-gray-600 mt-2 line-clamp-2"><?php echo htmlspecialchars($post['description']); ?>
                </p>
                <div class="mt-4 flex justify-between">
                    <a href="#" onclick="event.preventDefault(); openEditModal(<?php echo $post['id']; ?>);"
                        class="text-indigo-600 hover:text-indigo-900">
                        <i class="material-icons">edit</i>
                    </a>
                    <a href="#" onclick="event.preventDefault(); deletePost(<?php echo $post['id']; ?>)"
                        class="text-red-600 hover:text-red-900">
                        <i class="material-icons">delete</i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Desktop View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider"
                            style="width: 90%;">
                            Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider hidden-on-mobile"
                            style="width: 5%;">
                            Edit
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-primary uppercase tracking-wider hidden-on-mobile"
                            style="width: 5%;">
                            Delete
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($posts as $post): ?>
                    <tr id="post-row-<?php echo $post['id']; ?>">
                        <td class="px-6 py-4 whitespace-nowrap" style="width: 96%;">
                            <div class="text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($post['title']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden-on-mobile" style="width: 3%;">
                            <a href="#" onclick="event.preventDefault(); openEditModal(<?php echo $post['id']; ?>);"
                                class="text-indigo-600 hover:text-indigo-900">
                                <i class="material-icons">edit</i>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden-on-mobile" style="width: 3%;">
                            <a href="#" onclick="event.preventDefault(); deletePost(<?= $post['id'] ?>);"
                                class="text-red-600 hover:text-red-900 ml-2">
                                <i class="material-icons">delete</i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Edit Modal -->

    <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold mb-4">Edit Post</h2>
                <a href="#" onClick="closeEditModal()" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <i class="material-icons mr-2">close</i>

                </a>
            </div>


            <form id="edit-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="post_id" id="post-id">
                <div class="mb-4">
                    <label for="edit-title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="edit-title" name="title" placeholder="Enter your title"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="edit-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="edit-description" name="description" rows="4" placeholder="Enter your description"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit-image" class="block text-sm font-medium text-gray-700">Featured Image</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <span class="material-icons mx-auto h-15 w-15 text-primary">cloud_upload</span>
                            <div class="flex text-sm text-gray-600">
                                <label for="edit-image-upload"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:bg-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a photo</span>
                                    <input id="edit-image-upload" name="image" type="file" accept="image/*"
                                        class="sr-only">
                                </label>
                                <p class="pl-1">or paste URL</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white px-4 py-2 rounded-md hover:bg-dark-primary transition duration-300">
                    Submit
                </button>
            </form>
        </div>
    </div>



    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">
            <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
            <p>Are you sure you want to delete this post?</p>
            <div class="mt-4 flex justify-between">
                <button onclick="closeConfirmModal()" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button onclick="deletePostWithConfirmation(<?php echo $post['id']; ?>)"
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-dark-primary transition duration-300">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/dashboardScript.js"></script>


</body>

</html>