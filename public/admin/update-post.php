<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Start output buffering
ob_start();

require_once '../../vendor/autoload.php';

use LH\Models\Blog;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$postId = $_POST['post_id'] ?? null;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';

if (!$postId || !is_numeric($postId)) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
    exit;
}

if (empty($title) || empty($description)) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Title and description are required.']);
    exit;
}

$image = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../../public/assets/images/uploads/';
    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
    $filePath = $uploadDir . $fileName;

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        ob_end_clean();
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Image upload failed']);
        exit;
    }

    $image = $fileName;
}

try {
    $blogModel = new Blog();
    $result = $blogModel->updatePost((int)$postId, $title, $description, $image);

    ob_end_clean();

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
    } else {
        throw new \Exception('Failed to update post.');
    }
} catch (\Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}