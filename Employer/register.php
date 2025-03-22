<?php

include 'dbconfig.php';
session_start();
$servername = "localhost";
$username = "root"; // Change as per your DB user
$password = ""; // Change as per your DB password
$dbname = "homecare_experts"; // Change as per your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concern_person = $_POST["concern_person"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $company = $_POST["company"];
    $tagline = $_POST["tagline"];
    $description = $_POST["description"];
    $website = $_POST["website"];
    $gstin = $_POST["gstin"];
    $phone = $_POST["phone"];

    // Check if user exists
    $checkQuery = "SELECT * FROM employers WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit();
    }

    // Insert new user
    $query = "INSERT INTO employers (concern_person, email, password, company, tagline, description, website, gstin, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssss", $concern_person, $email, $password, $company, $tagline, $description, $website, $gstin, $phone);

    if ($stmt->execute()) {
        echo json_encode(["Registration successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed"]);
    }
}
$conn->close();
