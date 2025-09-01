<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

// Get user portfolio
$portfolio = getUserPortfolio($_SESSION['user_id']);

echo json_encode([
    'success' => true,
    'portfolio' => $portfolio
]);
?>
