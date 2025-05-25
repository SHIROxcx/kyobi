<?php
require 'connect.php';
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $username = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));

    // Validate required fields
    if (!$username || !$email || empty($password) || !$phone) {
        echo "<script>alert('All fields are required and must be valid.'); window.history.back();</script>";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM user_acc WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('This email is already in use. Please try another one.'); window.history.back();</script>";
        $stmt->close();
        exit;
    }

    // Proceed to register user
    $stmt->close();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user_acc (Username, Email, Password, phone_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $phone);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href = '../login.html';</script>";
    } else {
        error_log("Signup error: " . $stmt->error);
        echo "<script>alert('An error occurred during registration. Please try again later.'); window.location.href = '../signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = '../signup.html';</script>";
}
?>
