<?php 
require "config.php";

if (isset($_POST['update'])) {

    $user_id = $_POST['user_id'];
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $product = $_POST['product'];
    $amount  = $_POST['amount'];

    // Update users table
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$name, $email, $user_id]);

    // Update orders table
    $stmt2 = $pdo->prepare("UPDATE orders SET product = ?, amount = ? WHERE user_id = ?");
    $stmt2->execute([$product, $amount, $user_id]);

    header("Location: landing.php");
    exit;
}
?>