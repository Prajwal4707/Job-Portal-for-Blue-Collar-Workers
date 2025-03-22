<?php
require 'config.php'; // Ensure PDO connection is properly set

if (!isset($_GET['id'])) {
    die(json_encode(["status" => "error", "message" => "Employer ID is missing."]));
}

$employer_id = intval($_GET['id']); // Ensure the ID is an integer

try {
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM employers WHERE id = ?");
    $stmt->execute([$employer_id]);

    // Check if any row was deleted
    if ($stmt->rowCount() > 0) {
        echo json_encode(["Employer deleted successfully."]);
    } else {
        echo json_encode(["Employer not found or already deleted."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>
