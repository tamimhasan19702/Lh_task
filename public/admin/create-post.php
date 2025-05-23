<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}


require_once '../../vendor/autoload.php';


use LH\Helpers\ConstantHelper;
use LH\Models\Blog;

// Define BASE_URL
ConstantHelper::initialize();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? [];

    // Save image if uploaded
    $fileName = null;
    if (!empty($image) && $image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../public/assets/images/uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($image['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($image['tmp_name'], $filePath)) {
            die("Failed to upload image.");
        }
    }

    // Create blog post
    $blogModel = new Blog();
    $result = $blogModel->createPost($title, $description, $fileName);

    if ($result) {
        header('Location: dashboard.php?success=true&message=' . urlencode('Post created successfully.'));
        exit;
    } else {
        die("Failed to save post.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="../assets/css/output.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat :wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons " rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto px-6 py-8">
        <!-- Back to Dashboard -->
        <a href="<?= BASE_URL ?>/admin/dashboard.php" class="text-gray-600 hover:text-gray-800 flex items-center mb-4">
            <i class="material-icons mr-2">arrow_back</i> Back to dashboard
        </a>

        <h2 class="text-xl font-bold mb-4 mt-8">Create New Post</h2>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" placeholder="Enter your title"
                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter your description"
                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Featured Image</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <span class="material-icons mx-auto h-15 w-15 text-primary">cloud_upload</span>
                        <div class="flex text-sm text-gray-600">
                            <label for="image-upload"
                                class="relative cursor-pointer  rounded-md font-medium text-indigo-600  focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload a photo</span>
                                <input id="image-upload" name="image" type="file" accept="image/*" class="sr-only">
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
</body>

</html>