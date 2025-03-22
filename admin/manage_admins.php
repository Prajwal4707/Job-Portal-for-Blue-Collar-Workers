<?php
require 'config.php';

// Handle Add Admin Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $full_name = $_POST['full_name'];

    // Insert into admins table
    $sql = "INSERT INTO admins (email, password, full_name) VALUES (:email, :password, :full_name)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password' => $password,
        ':full_name' => $full_name
    ]);

    // Redirect to avoid form resubmission
    header("Location: manage_admins.php");
    exit;
}

// Handle Delete Admin Request
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Delete from admins table
    $sql = "DELETE FROM admins WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    // Redirect to avoid resubmission
    header("Location: manage_admins.php");
    exit;
}

// Fetch all admins
$admins = $conn->query("SELECT * FROM admins")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - HomeCare Experts</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="backtotop.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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

        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-container h3 {
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .admin-table th,
        .admin-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .admin-table th {
            background-color: #f2f2f2;
        }

        .admin-table tr:hover {
            background-color: #f5f5f5;
        }

        .admin-table .actions {
            white-space: nowrap;
        }

        .admin-table .actions a {
            margin-right: 10px;
            color: #dc3545;
            text-decoration: none;
        }

        .admin-table .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="menu-icon">☰</div>
        <h1>Manage Admins</h1>
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
        <section id="manage-admins">
            <div class="section-header">
                <h1>Manage Admins</h1>
            </div>

            <!-- Add Admin Form -->
            <div class="form-container">
                <h3>Add New Admin</h3>
                <form action="manage_admins.php" method="POST">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div>
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>
                    <button type="submit" name="add_admin">Add Admin</button>
                </form>
            </div>

            <!-- Admins Table -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin['id']); ?></td>
                            <td><?= htmlspecialchars($admin['email']); ?></td>
                            <td><?= htmlspecialchars($admin['full_name']); ?></td>
                            <td class="actions">
                                <a href="manage_admins.php?delete_id=<?= $admin['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>