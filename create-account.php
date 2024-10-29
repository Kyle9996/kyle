<?php
// Include database connection
require 'db.php'; // Make sure this file connects to your database

// Initialize variables
$username = $password = $confirm_password = "";
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic form validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password before saving
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Connect to the database (change with your connection details)
        $conn = new mysqli('localhost', 'root', '', 'SK'); // Your database connection

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password); // Use "ss" since both are strings

        // Execute the statement
        if ($stmt->execute()) {
            echo "New account created successfully!";
            header("Location: login.php"); // Redirect to login page after registration
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main">
        <img src="img/logo.png" alt="Logo" style="width: 120px; height:auto; margin-bottom: 0;">
        <h1 style="margin-top: 0px; color: #cc0c24; font-size: 30px">Create an Account</h1>
        
        <!-- Registration form -->
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required value="<?php echo htmlspecialchars($username); ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your Password" required>

            <div class="wrap">
                <button type="submit">Create Account</button>
            </div>
        </form>

        <!-- Display errors if any -->
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <p>Already have an account?
            <a href="login.php" style="text-decoration: none;">Login here</a>
        </p>
    </div>
</body>

</html>
