<?php
session_start();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'preschool_math');

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
    } else {
        $_SESSION['register_error'] = "Error: " . $sql . "<br>" . $conn->error;
        header('Location: register.html');
    }

    $conn->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php
        if (isset($_SESSION['register_error'])) {
            echo "<p class='error'>" . $_SESSION['register_error'] . "</p>";
            unset($_SESSION['register_error']); // Remove error after displaying it
        }
        ?>        
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
