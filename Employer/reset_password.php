<?php
session_start();
require "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $new_password = password_hash($_POST["new_password"], PASSWORD_BCRYPT);

    if (!isset($_SESSION['reset_token']) || $_SESSION['reset_token'] != $token) {
        echo "Invalid token.";
        exit;
    }

    $email = $_SESSION['reset_email'];

    // Update password
    $sql = "UPDATE employers SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $email);
    $stmt->execute();

    // Clear session token
    unset($_SESSION['reset_token']);
    unset($_SESSION['reset_email']);

    echo "Password reset successful!";
}

$conn->close();
