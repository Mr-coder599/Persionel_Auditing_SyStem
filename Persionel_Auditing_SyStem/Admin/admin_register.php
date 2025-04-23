<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'personnel_auditing');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert admin details into the database
    $sql = "INSERT INTO admin (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration successful! You can now login.');
                window.location='admin_login.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        /* Page styles */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #283c86, #45a247);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        /* Card styles */
        .card {
            width: 100%;
            max-width: 500px;
            border: none;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.5);
        }

        .card-header {
            background-color: #101011FF;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
        }

        button {
            margin-top: 15px;
            width: 100%;
            color: white;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            display: flex;

        }

        input {
            width: 100%;
            margin-top: 5px;
        }

        .form-group {
            width: 100%;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            Admin Registration
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <!-- Name Input -->
                <div class="form-group mb-4">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>
                </div>

                <!-- Email Input -->
                <div class="form-group mb-2">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address" required>
                </div>

                <!-- Password Input -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Create a password" required>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            <p class="text-muted text-center mt-3">Already have an account? <a href="admin_login.php" class="text-decoration-none">Login here</a></p>
        </div>
    </div>
</body>

</html>