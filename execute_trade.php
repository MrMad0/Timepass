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

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

$action = $_POST['action'] ?? '';
$symbol = $_POST['symbol'] ?? '';
$quantity = (int)($_POST['quantity'] ?? 0);

// Validate inputs
if (!in_array($action, ['buy', 'sell'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit();
}

if (empty($symbol) || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid symbol or quantity']);
    exit();
}

// Get current stock price
$stock = getStock($symbol);
if (!$stock) {
    echo json_encode(['success' => false, 'message' => 'Stock not found']);
    exit();
}

$price = $stock['current_price'];

// Execute the trade
$result = executeTrade($_SESSION['user_id'], $symbol, $action, $quantity, $price);

if ($result) {
    echo json_encode([
        'success' => true, 
        'message' => ucfirst($action) . ' order executed successfully',
        'trade' => [
            'symbol' => $symbol,
            'action' => $action,
            'quantity' => $quantity,
            'price' => $price,
            'total' => $quantity * $price
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Trade execution failed']);
}
?>
