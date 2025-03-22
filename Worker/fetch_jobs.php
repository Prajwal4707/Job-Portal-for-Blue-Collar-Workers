<?php
include 'db.php';

error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Display errors

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch jobs from database with employer name
$sql = "SELECT jobs.title, jobs.description, jobs.requirements, jobs.salary, jobs.location, jobs.created_at, employers.concern_person AS employer_name 
        FROM jobs
        JOIN employers ON jobs.employer_id = employers.id
        ORDER BY jobs.created_at DESC";
$result = $conn->query($sql);

// Output job data
if ($result->num_rows > 0) {
    $jobs = [];
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
    echo json_encode($jobs); // Output data
} else {
    echo "No jobs found"; // Debugging message
}
$conn->close();
?>
