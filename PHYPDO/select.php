<?php
require 'config.php';

// Join users with their orders
$stmt = $pdo->query('
    SELECT u.user_id, u.name, u.email, 
           o.product, o.amount, o.order_id
    FROM users u
    LEFT JOIN orders o ON u.user_id = o.user_id
    ORDER BY u.user_id DESC, o.order_id DESC
');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
