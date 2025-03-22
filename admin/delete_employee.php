<?php
require 'config.php'; // Ensure PDO connection is properly set

if (!isset($_GET['id'])) {
    die(json_encode(["status" => "error", "message" => "Employee ID is missing."]));
}

$employee_id = intval($_GET['id']); // Ensure the ID is an integer

try {
    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM applications WHERE id = ?");
    $stmt->execute([$employee_id]);

    // Check if any row was deleted
    if ($stmt->rowCount() > 0) {
        echo json_encode(["Employee deleted successfully."]);
    } else {
        echo json_encode(["Employee not found or already deleted."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>
