<?php
// Database connection parameters
$host = 'localhost'; // Database host
$user = 'root';      // Database username
$password = '';      // Database password
$db_name = 'SK'; // Database name

// Create connection
$conn = new mysqli($host, $user, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
