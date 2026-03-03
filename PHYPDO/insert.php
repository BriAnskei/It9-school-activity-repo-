<?php
require 'config.php';

// Process the form when submitted
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $product = $_POST['product'];
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);

    $users_id = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare("INSERT INTO orders (user_id, product, amount) VALUES (?, ?, ?)");
    $stmt2->execute([$users_id, $product, $amount]);

    echo "<p style='color: green;'>User and order added successfully!</p>";
}
?>

