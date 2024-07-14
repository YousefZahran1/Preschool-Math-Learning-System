<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preschool Math Learning System</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div class="video-background">
        <video autoplay muted loop id="bg-video">
            <source src="background_video.mp4" type="video/mp4">
        </video>
</div>
    <div class="container">
        <h1>Welcome to the Preschool Math Learning System</h1>
        <?php
        if (isset($_SESSION['welcome'])) {
            echo "<p class='welcome-message'>" . htmlspecialchars($_SESSION['welcome']) . "</p>";
            unset($_SESSION['welcome']);
        } elseif (isset($_SESSION['username'])) {
            header('Location: dashboard.php');
            exit;
        }
        ?>
        <nav>
            <?php if (!isset($_SESSION['username'])): ?>
                <button onclick="window.location.href='login.html'">Login</button>
                <button onclick="window.location.href='register.html'">Register</button>
            <?php endif; ?>
        </nav>
    </div>
    <script src="script.js"></script>
</body>
</html>
