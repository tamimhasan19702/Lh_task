// public/admin/create-post.php
<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/db.php';
$blogModel = new LH\Models\Blog();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
        $uploadDir = '../img/';
        $fileName = basename($_FILES['image']['name']);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid() . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $newFileName;

        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = $newFileName;
            } else {
                die('Failed to upload image');
            }
        } else {
            die('Invalid file type');
        }
    }

    if ($blogModel->createPost($title, $description, $image)) {
        header('Location: dashboard.php');
        exit;
    } else {
        die('Failed to create post');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss @2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="#" class="text-xl font-bold text-gray-800">Admin Panel</a>
            <a href="logout.php" class="text-gray-600 hover:text-gray-800">Logout</a>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold mb-4">Create New Post</h1>
        <form action="" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="5"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <div class="mb-6">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                <input type="file" name="image" id="image"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</body>

</html>