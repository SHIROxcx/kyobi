<?php
$servername = "your_server";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the item id from the request
parse_str(file_get_contents("php://input"), $post_vars);
$item_id = intval($post_vars['id']);

if ($item_id) {
    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["message" => "Item deleted successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Error deleting item."]);
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["message" => "Invalid item id."]);
}
$conn->close();
?>