<?php
session_start();
header("Content-Type: application/json");
require "dbconfig.php"; // Database connection

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || empty($data['email'])) {
    echo json_encode(["message" => "Email is required"]);
    exit;
}

$email = $data['email'];

// Check if email exists
$sql = "SELECT id FROM employers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Generate a random 6-digit token
    $reset_token = rand(100000, 999999);

    // Store reset token in session instead of database
    $_SESSION['reset_token'] = $reset_token;
    $_SESSION['reset_email'] = $email;

    echo json_encode(["reset_token" => $reset_token]);
} else {
    echo json_encode(["message" => "Email not found"]);
}

$conn->close();
