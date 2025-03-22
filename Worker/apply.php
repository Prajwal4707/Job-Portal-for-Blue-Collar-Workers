<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $applicant_name = $_POST['applicant_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO applications (job_id, applicant_name, email, phone) VALUES ('$job_id', '$applicant_name', '$email', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Application submitted successfully!'); window.location.href='jobs.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Apply for Job</h1>
    </header>
    <div class="container">
        <form method="POST" action="apply.php">
            <input type="hidden" name="job_id" value="<?php echo $_GET['job_id']; ?>">
            <label for="applicant_name">Full Name:</label>
            <input type="text" id="applicant_name" name="applicant_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <button type="submit">Submit Application</button>
        </form>
    </div>
</body>
</html>
