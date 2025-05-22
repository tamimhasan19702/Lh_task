<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../../vendor/autoload.php';

use LH\Models\Blog;

// Get post ID from query parameter
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
    exit;
}

try {
    $blogModel = new Blog();
    $post = $blogModel->getPostById((int)$id);

    if ($post) {
        echo json_encode([
            'success' => true,
            'post' => [
                'title' => htmlspecialchars($post['title']),
                'description' => htmlspecialchars($post['description']),
                'image' => htmlspecialchars($post['image'] ?? ''),
            ],
        ]);
    } else {
        throw new \Exception('Post not found');
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}