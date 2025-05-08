<?php
session_start();
require_once '../classes/User.php';
require_once '../classes/Product.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user = $_SESSION['user'];

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Get orders for the logged-in user
    $stmt = $conn->prepare("
        SELECT o.*, p.name as product_name 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        WHERE o.user_id = :user_id 
        ORDER BY o.created_at DESC
    ");
    $stmt->bindParam(':user_id', $user['id']);
    $stmt->execute();
    
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($orders);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?> 