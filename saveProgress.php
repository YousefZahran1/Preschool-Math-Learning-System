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

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data) {
    $activity = $data['activity'];
    $score = $data['score'];
    $total = $data['total'];
    $completed = $data['completed'] ? 1 : 0;
    $type = $data['type']; // 'game' or 'lesson'

    if ($type == 'game') {
        $table = 'game_progress';
    } elseif ($type == 'lesson') {
        $table = 'lesson_progress';
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid type']);
        exit;
    }

    // Check if the record already exists
    $query = "SELECT * FROM $table WHERE user_id = ? AND activity = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $activity);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $query = "UPDATE $table SET score = ?, total = ?, completed = ? WHERE user_id = ? AND activity = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiisi", $score, $total, $completed, $user_id, $activity);
    } else {
        // Insert new record
        $query = "INSERT INTO $table (user_id, activity, score, total, completed) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isiii", $user_id, $activity, $score, $total, $completed);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Progress saved']);
    } else {
        // Log the error
        error_log('Database error: ' . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Failed to save progress']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or data']);
}
?>
