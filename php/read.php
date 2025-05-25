<?php
session_start();
include "connect.php"; // Make sure this path is correct

// Redirect unauthenticated users
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.html"); // Adjust path if needed
    exit();
}

$userId = $_SESSION['user_id'];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

// You can now loop through $result to display cart items

$stmt->close();
$conn->close();
?>
