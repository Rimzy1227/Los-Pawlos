<?php
session_start();
require 'db_connection.php'; // your PDO connection setup file

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("User not logged in");
}

// Fetch cart items from DB for user
$stmt = $pdo->prepare("SELECT product_id, quantity, price FROM cart_items JOIN products ON cart_items.product_id = products.id WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

if (empty($cart_items)) {
    die("Your cart is empty.");
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

$status = 'pending';

try {
    $pdo->beginTransaction();

    // Insert into orders table
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$user_id, $total, $status]);
    $order_id = $pdo->lastInsertId();

    // Insert each order item
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
    }

    // Clear cart
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $stmt->execute([$user_id]);

    $pdo->commit();

    // Redirect to confirmation page or account orders tab
    header("Location: account.php?tab=orders&order_success=1");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Failed to place order: " . $e->getMessage());
}
