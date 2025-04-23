<?php
session_start();

/* Database Connection */
include '../db/db_connection.php';

/* Handle Form Submission */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if admin exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['email'];
            header("Location: admin_dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Admin not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Personnel Auditing System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            color: #1e3c72;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 5px;
            display: flex;
        }

        .form-control:focus {
            border-color: #1e3c72;
            box-shadow: none;
        }

        input {
            width: 100%;
            padding: 5px;
            border: 2px solid blue;
            line-height: 1.3;
            margin-top: 5px;
        }

        .btn-login {
            background: #1e3c72;
            border: none;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            transition: background 0.3s ease;
        }

        .btn-login:hover {
            background: #2a5298;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="email" class="form-control" placeholder="Enter your Email" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-login">Login</button><br>
            Don't have an account...?<a href="./admin_register.php">Register</a>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>