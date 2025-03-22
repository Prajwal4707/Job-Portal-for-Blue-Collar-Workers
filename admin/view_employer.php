<?php
require 'config.php'; // Ensure config.php contains the correct PDO connection

if (!isset($_GET['id'])) {
    die("Employer ID is missing.");
}

$employer_id = intval($_GET['id']); // Convert to integer for security

try {
    // Fetch employer details using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM employers WHERE id = ?");
    $stmt->execute([$employer_id]);
    $employer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employer) {
        die("No employer found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Details</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        /* Container Styles */
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Employer Details Styling */
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        strong {
            color: #000;
        }

        /* Links */
        a {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        a:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Employer Details</h1>
    <p><strong>Company Name:</strong> <?php echo htmlspecialchars($employer['company']); ?></p>
    <p><strong>Concern Person:</strong> <?php echo htmlspecialchars($employer['concern_person']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($employer['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($employer['phone']); ?></p>
    <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($employer['website']); ?>" target="_blank"><?php echo htmlspecialchars($employer['website']); ?></a></p>
    <p><strong>Tagline:</strong> <?php echo htmlspecialchars($employer['tagline']); ?></p>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($employer['description'])); ?></p>
    <p><strong>GSTIN:</strong> <?php echo htmlspecialchars($employer['gstin']); ?></p>
    <p><a href="https://services.gst.gov.in/services/searchtp" target="_blank">Verify GSTIN</a></p>

    <a href="new.php">Back to Dashboard</a>
</body>

</html>