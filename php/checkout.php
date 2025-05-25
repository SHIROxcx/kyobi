<?php
session_start();
require 'connect.php';
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.html');
        exit();
    }

    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $total_price = filter_var($_POST['total_price'] ?? '', FILTER_VALIDATE_FLOAT);
    $total_quantity = filter_var($_POST['total_quantity'] ?? '', FILTER_VALIDATE_INT);
    $user_id = $_SESSION['user_id'];

    // Validate required fields
    if (!$name || !$phone || !$address || !$country || !$city || $total_price === false || $total_quantity === false) {
        header('Location: ../cart.php?error=Invalid input. Please check your form.');
        exit();
    }

    // Insert order securely using prepared statement
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, phone, address, country, city, total_price, total_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssdi", $user_id, $name, $phone, $address, $country, $city, $total_price, $total_quantity);

    if ($stmt->execute()) {
        // Delete cart items
        $del_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $del_stmt->bind_param("i", $user_id);
        $del_stmt->execute();

        header('Location: ../checkout.html');
        exit();
    } else {
        error_log("Checkout failed: " . $stmt->error);
        header('Location: ../cart.php?error=Checkout error. Please try again.');
        exit();
    }

    $stmt->close();
    $del_stmt->close();
    $conn->close();
} else {
    header('Location: ../cart.php');
    exit();
}
