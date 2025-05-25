<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['image_url'])) {
    // User is logged in, proceed to save the product
    include "connect.php";

    $productName = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $imageUrl = mysqli_real_escape_string($conn, $_POST['image_url']);
    $userID = $_SESSION['user_id'];

    // Perform the product saving operation here, using $productName, $price, $imageUrl, and $userID
    // Example SQL query to insert product into a user's cart
    $query = "INSERT INTO cart (product_name, price, image_url, user_id) VALUES ('$productName','$price','$imageUrl','$userID')";
    if (mysqli_query($conn, $query)) {
        echo "Product added to cart successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Unauthorized access.";
}
?>