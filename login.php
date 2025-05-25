<?php
session_start();
require 'php/connect.php'; // Adjust path if needed

// Set secure headers
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Allow only POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Sanitize and validate inputs
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$email || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Valid email and password are required.']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, Email, Password FROM user_acc WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
        exit;
    }

    $user = $result->fetch_assoc();
    if (!password_verify($password, $user['Password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
        exit;
    }

    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['Email'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful!',
        'redirect_url' => 'index1.html'
    ]);
} catch (Exception $e) {
    // In production, log the error instead of showing it
    error_log("Login error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong.']);
}

$stmt->close();
$conn->close();
?>
