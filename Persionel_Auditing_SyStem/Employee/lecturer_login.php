<?php
session_start();
include '../db/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query to check if the lecturer exists
    $stmt = $conn->prepare("SELECT id, name, password FROM lecturers WHERE email = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['lecturer_id'] = $row['id'];
            $_SESSION['lecturer_name'] = $row['name'];
            header("Location: lecturer_dashboard.php"); // Redirect to the lecturer's dashboard
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "No lecturer found with that email!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #007bff, #6c757d);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #007bff;
            text-align: center;
        }

        .btn-login {
            background: #007bff;
            border: none;
            color: #fff;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }

        .btn-login:hover {
            background: #0056b3;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Lecturer Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
        <p class="text-center mt-3">
            <a href="lecturer_reg.php" class="text-primary">Don't have an account? Register here</a>
        </p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>