<?php
session_start();

// Check authentication
if (!isset($_SESSION['authenticated'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Autoload classes
require_once '../../vendor/autoload.php';

use LH\Models\Blog;

// Get ID from query param
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
    exit;
}

try {
    $blogModel = new Blog();
    $result = $blogModel->deletePost((int)$id);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Post deleted successfully']);
    } else {
        throw new \Exception('Failed to execute deletion');
    }
} catch (\PDOException $e) {
    // Log detailed error (for debugging only, hide in production)
    error_log("PDO Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}