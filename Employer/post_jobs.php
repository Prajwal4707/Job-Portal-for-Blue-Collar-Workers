<?php
session_start();
include 'dbconfig.php'; // Database connection

// Get employer's approval status
$employer_id = $_SESSION["user_id"] ?? 1; // Replace with session-based employer ID
$query = "SELECT status FROM employers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$employer = $result->fetch_assoc();

if ($employer['status'] != 'approved') {
    echo "<script>alert('Your account is pending approval. You cannot post jobs at the moment.'); window.location.href='dashboard.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $requirements = $conn->real_escape_string($_POST["requirements"]);
    $salary = $conn->real_escape_string($_POST["salary"]);
    $location = $conn->real_escape_string($_POST["location"]);

    $sql = "INSERT INTO jobs (employer_id, title, description, requirements, salary, location) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $employer_id, $title, $description, $requirements, $salary, $location);

    if ($stmt->execute()) {
        echo "<script>alert('Job posted successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error posting job!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            /* Soft cyan-blue gradient */
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.7);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.8s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
        }

        label {
            font-weight: 500;
            color: #444;
            display: block;
            margin-top: 10px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            transition: 0.3s ease-in-out;
            border: 1px solid #ddd;
        }

        input::placeholder,
        textarea::placeholder {
            color: rgba(51, 51, 51, 0.5);
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #80deea;
            box-shadow: 0px 0px 8px rgba(128, 222, 234, 0.5);
        }

        textarea {
            resize: none;
            min-height: 100px;
        }

        button {
            width: 100%;
            background:rgb(65, 161, 224);
            /* Soft teal */
            color: white;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            margin-top: 15px;
            font-weight: 600;
        }

        button:hover {
            background:rgb(45, 136, 172);
            /* Darker teal */
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.98);
        }

        @media (max-width: 480px) {
            .container {
                max-width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Post a New Job</h2>
        <form method="POST" action="">
            <label>Job Title</label>
            <input type="text" name="title" required placeholder="Enter job title">

            <label>Job Description</label>
            <textarea name="description" required placeholder="Enter job description"></textarea>

            <label>Requirements</label>
            <textarea name="requirements" required placeholder="Enter job requirements"></textarea>

            <label>Salary</label>
            <input type="text" name="salary" placeholder="Enter salary (optional)">

            <label>Location</label>
            <input type="text" name="location" required placeholder="Enter location">

            <button type="submit">Post Job</button>
        </form>
    </div>
</body>

</html>