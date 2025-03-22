<?php
require 'config.php';

// Fetch Data
$applicants = $conn->query("SELECT * FROM applications")->fetchAll(PDO::FETCH_ASSOC);
$workers = $conn->query("SELECT * FROM workers")->fetchAll(PDO::FETCH_ASSOC);
$employers = $conn->query("SELECT * FROM employers")->fetchAll(PDO::FETCH_ASSOC);
$jobs = $conn->query("SELECT * FROM jobs")->fetchAll(PDO::FETCH_ASSOC);
$users = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$settings = $conn->query("SELECT * FROM settings")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - HomeCare Experts</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="backtotop.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script>
        (function() {
            emailjs.init("uAC1dSEeZrHZd_QTZ"); // Replace with your EmailJS Public Key
        })();
    </script>
    <style>
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
        }

        .badge.Approved {
            background-color: green;
            color: white;
        }

        .badge.Rejected {
            background-color: red;
            color: white;
        }

        .badge.Pending {
            background-color: orange;
            color: white;
        }

        .approve-btn {
            border-radius: 10px;
            background-color: green;
        }

        .reject-btn {
            border-radius: 10px;
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="menu-icon">☰</div>
        <h1>Dashboard</h1>
    </div>
    <nav class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="new.php">Dashboard</a></li>
            <li><a href="manage_admins.php">Manage Admins</a></li>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </nav>

    <main class="content">
        <section id="dashboard">
            <p>Welcome to the HomeCare Experts Admin Panel.</p>
        </section>

        <section id="employers">
            <div class="section-header">
                <h1>Registered Employers</h1>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employers as $employer): ?>
                        <tr>
                            <td><?= htmlspecialchars($employer['company']) ?></td>
                            <td><?= htmlspecialchars($employer['email']) ?></td>
                            <td><?= htmlspecialchars($employer['phone']) ?></td>
                            <td class="status-<?= $employer['id'] ?>">
                                <?php
                                $status = !empty($employer['status']) ? ucfirst(strtolower($employer['status'])) : 'Pending';
                                ?>
                                <span class="badge <?= $status ?>"><?= $status ?></span>
                            </td>
                            <td>
                                <?php if ($status === 'Pending'): ?>
                                    <button class="approve-btn" data-id="<?= $employer['id'] ?>" data-email="<?= $employer['email'] ?>" data-name="<?= $employer['company'] ?>" data-status="Approved">Approve</button>
                                    <button class="reject-btn" data-id="<?= $employer['id'] ?>" data-email="<?= $employer['email'] ?>" data-name="<?= $employer['company'] ?>" data-status="Rejected">Reject</button>
                                <?php endif; ?>
                                <a href="view_employer.php?id=<?= $employer['id']; ?>" class="btn btn-info btn-sm">View</a>
                                <a href="delete_employer.php?id=<?= $employer['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this employer?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            $(".approve-btn, .reject-btn").click(function() {
                var employerId = $(this).data("id");
                var employerEmail = $(this).data("email");
                var employerName = $(this).data("name");
                var status = $(this).data("status");
                var buttonRow = $(this).closest("td");
                var statusCell = $(".status-" + employerId);

                $.ajax({
                    url: "approve_employer.php",
                    type: "POST",
                    data: {
                        employer_id: employerId,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        statusCell.html('<span class="badge ' + status + '">' + status + '</span>');
                        buttonRow.html('');

                        // Send Email via EmailJS
                        var templateParams = {
                            to_email: employerEmail,
                            employer_name: employerName,
                            status: status
                        };

                        emailjs.send("service_1ggs94j", "template_s590sgt", templateParams)
                            .then(function(response) {
                                console.log("Email sent successfully", response);
                            })
                            .catch(function(error) {
                                console.error("Email sending failed", error);
                            });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + error);
                    }
                });
            });
        });
    </script>
</body>

</html>