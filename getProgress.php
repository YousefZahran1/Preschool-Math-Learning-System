<?php
session_start();
include 'db_connection.php'; // Ensure this file handles the database connection

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Get user ID from the database
$username = $_SESSION['username'];
$query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Fetch game progress
$query = "SELECT activity, score, total, completed FROM game_progress WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$game_progress = [];
while ($row = $result->fetch_assoc()) {
    $game_progress[] = $row;
}

// Fetch lesson progress
$query = "SELECT activity, score, total, completed FROM lesson_progress WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$lesson_progress = [];
while ($row = $result->fetch_assoc()) {
    $lesson_progress[] = $row;
}

// Log the data for debugging
error_log("Game Progress: " . json_encode($game_progress));
error_log("Lesson Progress: " . json_encode($lesson_progress));

// Return progress data as JSON
echo json_encode([
    'status' => 'success',
    'game_progress' => $game_progress,
    'lesson_progress' => $lesson_progress
]);
?>
