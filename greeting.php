<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title> Greeting</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to the Home Page</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hello, <?php echo $_SESSION['username']; ?>! <a href="dashboard.php">Go to Dashboard</a></p>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> | <a href="register.php">Register</a>
    <?php endif; ?>
</body>
</html>
