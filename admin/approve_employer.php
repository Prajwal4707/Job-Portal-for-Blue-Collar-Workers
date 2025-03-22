<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["employer_id"]) && isset($_POST["status"])) {
        $employer_id = intval($_POST["employer_id"]);
        $status = $_POST["status"];

        try {
            $sql = "UPDATE employers SET status = :status WHERE id = :employer_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':employer_id', $employer_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Status updated to $status";
            } else {
                echo "Error updating status";
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Invalid request";
    }
}
