<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link rel="stylesheet" href="jobs.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="backtotop.css" />
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />

</head>

<body>
    <header>
        <h1>Blue Collar Job Portal</h1>
    </header>
    <div class="container">
        <?php
        $sql = "SELECT jobs.id, jobs.title, jobs.location, jobs.salary, employers.company 
        FROM jobs 
        JOIN employers ON jobs.employer_id = employers.id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='job-card'>
                <h3>{$row['title']}</h3>
                <p>Company: {$row['company']}</p>
                <p>Location: {$row['location']}</p>
                <p>Salary: {$row['salary']}</p>
                <a href='apply.php?job_id={$row['id']}' class='apply-button'>Apply Now</a>
            </div>";
            }
        } else {
            echo "<p>No jobs found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>

</html>