<?php
// Establish a database connection
include "connect.php";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["fName"];
    $lastName = $_POST["lName"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Prepare SQL statement to insert data into database
    $sql = "INSERT INTO contact_form (first_name, last_name, email, subject, message) 
            VALUES ('$firstName', '$lastName', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Close database connection
        $conn->close();

        echo "<script>alert('Form successfully submited!');
        window.location.href = '../contact.html';</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
