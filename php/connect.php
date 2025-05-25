<?php
$servername = "localhost"; // Database server
$username = "Shiro";    // Database username
$password = "";    // Database password
$dbname = "myweb";      // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
