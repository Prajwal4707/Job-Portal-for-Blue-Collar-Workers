<?php
require 'dbconfig.php';

// Handle Add Job Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_job'])) {
    $job_title = $_POST['job_title'];

    $sql = "INSERT INTO jobs (job_title, status) VALUES (?, 'open')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $job_title);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;
}

// Handle Delete Job Request
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM applications WHERE job_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $sql = "DELETE FROM jobs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;
}

// Handle Close Job Request
if (isset($_GET['close_id'])) {
    $id = $_GET['close_id'];

    $sql = "UPDATE jobs SET status = 'closed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;
}

// Fetch all jobs with applicant count from applications table
$sql = "
    SELECT
    j.id,
    j.title,
    j.status,
    COUNT(a.id) AS total_applicants,
    COUNT(CASE WHEN a.status = 'approved' THEN 1 END) AS approved_applicants
FROM
    jobs j
LEFT JOIN
    applications a ON j.id = a.job_id
GROUP BY
    j.id, j.title, j.status;
";
$result = $conn->query($sql);
$jobs = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total hired applicants
$total_hired = array_sum(array_column($jobs, 'approved_applicants'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f4f4f4;
            height: 100vh;
        }

        .navbar {
            background: #667eea;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-size: 16px;
        }

        .dashboard {
            width: 80%;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input,
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #667eea;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
        }

        .view-btn {
            background: #28a745;
            color: white;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .close-btn {
            background: #ff9800;
            color: white;
        }

        .highlight {
            background-color: yellow;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            width: 50%;
        }

        .modal h3 {
            margin-bottom: 10px;
        }

        .modal ul {
            list-style: none;
            padding: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="main.html"><img src="./images/HomeCare_logo.JPG" alt="HomeCare_Experts" height="40"></a>
        <div>
            <a href="main.html">Home</a>
            <a href="post_jobs.php">Post Jobs</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="../Employer/logout.php">Logout</a>
        </div>
    </nav>

    <div class="dashboard">
        <h2>Employer Dashboard</h2>
        <div class="controls">
            <input type="text" id="search-job" placeholder="Search jobs..." onkeyup="searchJobs()">
            <div class="total-hired">
                <h3>Total Hired Applicants: <span id="total-hired-count"><?= $total_hired ?></span></h3>
            </div>
            <button class="btn"><a href="post_jobs.php" style="text-decoration: none;">Post New Job</a> </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Applicants</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="job-list">
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['total_applicants']) ?></td>
                        <td><?= htmlspecialchars($job['status']) ?></td>
                        <td>
                            <button class="btn view-btn" onclick="window.location.href='view_applicants.php?job_id=<?= $job['id'] ?>'">View</button>

                            <?php if ($job['status'] === 'open'): ?>
                                <a href="dashboard.php?close_id=<?= $job['id'] ?>" class="btn close-btn">Close Job</a>
                            <?php else: ?>
                                <button class="btn close-btn" disabled>Closed</button>
                            <?php endif; ?>
                            <a href="dashboard.php?delete_id=<?= $job['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Job Modal -->
    <div id="job-modal" class="modal" style="display:none; position:fixed; top:20%; left:50%; transform:translate(-50%, 0); background:#fff; padding:20px; border:1px solid #ddd;">
        <button class="close-btn" onclick="closeJobModal()">X</button>
        <h3>Post New Job</h3>
        <form action="dashboard.php" method="POST">
            <div>
                <label for="job_title">Job Title:</label>
                <input type="text" id="job_title" name="job_title" required>
            </div>
            <button type="submit" name="add_job">Add Job</button>
        </form>
    </div>

    <script>
        function openJobModal() {
            document.getElementById("job-modal").style.display = "block";
        }

        function closeJobModal() {
            document.getElementById("job-modal").style.display = "none";
        }

        function searchJobs() {
            let input = document.getElementById("search-job").value.toLowerCase();
            let rows = document.querySelectorAll("#job-list tr");

            rows.forEach((row) => {
                let jobTitleCell = row.cells[0];
                let jobTitle = jobTitleCell.innerText.toLowerCase();

                if (jobTitle.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>