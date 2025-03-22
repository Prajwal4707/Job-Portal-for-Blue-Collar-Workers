<?php
session_start();
include 'db_config.php';

$email = $_POST['email'];
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes

$subject = "Your OTP Code";
$message = "Your OTP code is: $otp";
$headers = "From: noreply@example.com";

mail($email, $subject, $message, $headers);

echo json_encode(["status" => "success", "message" => "OTP sent successfully."]);
?>