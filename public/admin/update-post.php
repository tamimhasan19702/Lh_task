<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Load Composer autoloader
require_once '../../vendor/autoload.php';

use LH\Models\Blog;

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $postId = $_POST['post_id'] ?? null;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate required fields
    if (!$postId || !is_numeric($postId)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid or missing post ID']);
        exit;
    }

    if (empty($title) || empty($description)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Title and description are required.']);
        exit;
    }

    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../public/assets/images/uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        // Create uploads directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit;
        }

        $image = $fileName;
    }

    try {
        $blogModel = new Blog();
        $result = $blogModel->updatePost((int)$postId, $title, $description, $image);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
          
        } else {
            throw new \Exception('Failed to update post');
        }
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}