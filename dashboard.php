<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Preschool Math Learning System</title>
    <link rel="icon" type="image/x-icon" sizes="5000x5000" href="logo_pre.png">
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
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <nav>
            <button onclick="window.location.href='lessons.html'">Lessons</button>
            <button onclick="window.location.href='game.html'">Play Game</button>
            <button onclick="window.location.href='progress.html'">View Progress</button>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </nav>
    </div>
    <script src="script.js"></script>
</body>
</html>
