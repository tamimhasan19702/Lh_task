<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

require_once '../../vendor/autoload.php';

use LH\Models\Blog;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'] ?? null;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate inputs
    if (!$postId || !is_numeric($postId)) {
        header("Location: dashboard.php?success=false&message=Invalid+Post+ID");
        exit;
    }

    if (empty($title) || empty($description)) {
        header("Location: dashboard.php?success=false&message=Title+and+description+are+required");
        exit;
    }

    // Handle image upload
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../public/assets/images/uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            header("Location: dashboard.php?success=false&message=Image+upload+failed");
            exit;
        }

        $image = $fileName;
    }

    try {
        $blogModel = new Blog();
        $result = $blogModel->updatePost((int)$postId, $title, $description, $image);

        if ($result) {
            header("Location: dashboard.php?success=true&message=Post+updated+successfully.");
        } else {
            throw new \Exception("Failed to update post.");
        }
    } catch (\Exception $e) {
        header("Location: dashboard.php?success=false&message=" . urlencode($e->getMessage()));
    }

    exit;
}