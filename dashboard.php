<?php
// Start the session
session_start();

// Check if the user is logged in, redirect to login if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css"> <!-- Your custom CSS -->
    <style>
        /* Additional styling for logout button */
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 20px;
        }
    </style>
</head>
<body>
    <!-- Logout Button -->
    <form method="POST" action="" class="logout-btn">
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>

    <div class="container mt-5">
    <div class="text-center mb-5">
            <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        </div>
        <!-- Separate div for the Add Profile Button -->
        <div class="mb-3 d-flex justify-content-end">
            <a href="profiling.php" class="btn btn-primary">+Add Katipunan ng Kabataan Profile</a>
        </div>
    
        <div class="table-responsive">
            <!-- Table Section -->
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example rows - Replace this with your database query -->
                    <tr>
                        <td>1</td>
                        <td>john_doe</td>
                        <td>john@example.com</td>
                        <td>Admin</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>jane_doe</td>
                        <td>jane@example.com</td>
                        <td>User</td>
                    </tr>
                    <!-- Add more rows dynamically from the database -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
