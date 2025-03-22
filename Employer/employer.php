<?php
session_start();
include 'db_connection.php'; // Include database connection file

// Check if employer is logged in
if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit();
}

$employer_id = $_SESSION['employer_id'];
$query = "SELECT * FROM employers WHERE id = $employer_id";
$result = mysqli_query($conn, $query);
$employer = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Employer Panel</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Employer Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="update_profile.php">Update Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="post_job.php">Post a Job</a></li>
                <li class="nav-item"><a class="nav-link" href="view_applicants.php">View Applicants</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Welcome, <?php echo htmlspecialchars($employer['name']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($employer['email']); ?></p>
        <p>Status: <?php echo htmlspecialchars($employer['status']); ?></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>