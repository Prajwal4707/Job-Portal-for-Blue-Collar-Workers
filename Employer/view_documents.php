<?php
include 'dbconfig.php';

if (!isset($_GET['id'])) {
    die("Error: No applicant ID provided.");
}

$applicant_id = $_GET['id'];

$sql = "SELECT * FROM applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Applicant not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        h2 {
            color: #007bff;
        }

        a {
            display: block;
            margin: 10px 0;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Documents for <?php echo htmlspecialchars($row['name']); ?></h2>

        <?php if (!empty($row['photo'])): ?>
            <h3>Photo</h3>
            <a href="uploads/<?php echo $row['photo']; ?>" target="_blank" alt="Photo" width="100px">View Photo</a>

        <?php else: ?>
            <p>Photo Not Available</p>
        <?php endif; ?>

        <?php if (!empty($row['id_proof'])): ?>
            <h3>ID Proof</h3>
            <a href="uploads/<?php echo $row['id_proof']; ?>" target="_blank" alt="Id" width="150px">View ID Proof</a>
        <?php else: ?>
            <p>ID Proof Not Available</p>
        <?php endif; ?>

        <?php if (!empty($row['resume'])): ?>
            <h3>Resume</h3>
            <a href="uploads/<?php echo $row['resume']; ?>" target="_blank">View Resume</a>
        <?php else: ?>
            <p>Resume Not Available</p>
        <?php endif; ?>
    </div>
    <a href="dashboard.php" id="dashboard">Back to Dashboard</a>
</body>

</html>