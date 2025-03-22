<?php
session_start();

$enteredOTP = $_POST['otp'];
if (isset($_SESSION['otp']) && time() < $_SESSION['otp_expiry']) {
    if ($enteredOTP == $_SESSION['otp']) {
        echo json_encode(["status" => "success", "message" => "OTP verified successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect OTP."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "OTP expired or not generated."]);
}
?>