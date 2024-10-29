<?php
// Include database connection
require 'db.php'; // Include your database connection file

// Start session
session_start(); // Start a session to manage user login state

// Initialize variables
$username = $password = "";
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic form validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If there are no errors, proceed with login
    if (empty($errors)) {
        // Prepare and execute a query to check if the user exists
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if the username exists
        if ($stmt->num_rows > 0) {
            // Fetch the hashed password
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set session variable for the logged-in user
                $_SESSION['username'] = $username; // Save the username in the session
                
                // Redirect to the dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid password.";
            }
        } else {
            $errors[] = "No user found with that username.";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main">
        <img src="img/logo.png" alt="Logo" style="width: 120px; height:auto; margin-bottom: 0;">
        <h1 style="margin-top: 0px; color: #cc0c24; font-size: 30px">Sangguniang Kabataan <br> - KK Profiling</h1>
        
        <!-- Login form -->
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required value="<?php echo htmlspecialchars($username); ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit">Login</button>
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

        <p>Not registered?
            <a href="create-account.php" style="text-decoration: none;">Create an account</a>
        </p>
    </div>
</body>

</html>
