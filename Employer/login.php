<?php
session_start();
include 'dbconfig.php'; // Include database connection

$error_message = ""; // Initialize an empty error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    // Check if the email belongs to an admin
    $admin_sql = "SELECT id, email, password FROM admins WHERE email = ?";
    $admin_stmt = $conn->prepare($admin_sql);
    $admin_stmt->bind_param("s", $email);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();
    $admin_user = $admin_result->fetch_assoc();

    if ($admin_user && password_verify($password, $admin_user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $admin_user["id"];
        $_SESSION["email"] = $admin_user["email"];
        header("Location: /Jobportal/admin/new.php");
        exit;
    } else {
        // If not an admin, check if it's an employer
        $employer_sql = "SELECT id, email, password FROM employers WHERE email = ?";
        $employer_stmt = $conn->prepare($employer_sql);
        $employer_stmt->bind_param("s", $email);
        $employer_stmt->execute();
        $employer_result = $employer_stmt->get_result();
        $employer_user = $employer_result->fetch_assoc();

        if ($employer_user && password_verify($password, $employer_user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $employer_user["id"];
            $_SESSION["email"] = $employer_user["email"];
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Invalid email or password!"; // Store error message
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0;
        }

        .container {
            width: 30%;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        label {
            margin-top: 10px;
            font-weight: 500;
        }

        label i {
            margin-right: 10px;
            color: #2a6dff;
        }

        input {
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
        }

        input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.4);
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            width: 100%;
        }

        button:hover {
            background: linear-gradient(135deg, #5563c1, #5b3e82);
        }

        .signup-link,
        .forgot-password {
            font-family: "Poppins", sans-serif;
            margin-top: 15px;
            font-size: 14px;
            display: block;
        }

        .signup-link a,
        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover,
        .forgot-password a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Login</h2>

        <form method="POST">
            <label><i class="fas fa-envelope"></i> Email *</label>
            <input type="email" name="email" required>

            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" required>

            <button type="submit"><i class="fas fa-sign-in-alt"></i> Sign In</button>
        </form>

        <p class="signup-link">
            Don't have an account? <a href="emp_reg.html">Sign up</a>
        </p>
        <a href="forgot_pass.html" class="forgot-password">Forgot your password?</a>
        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
    </div>

</body>

</html>