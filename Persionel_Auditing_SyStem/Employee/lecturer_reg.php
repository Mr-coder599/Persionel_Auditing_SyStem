<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'personnel_auditing');
// require './db/db_connection.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $email = trim($_POST['email']);
    $department = trim($_POST['department']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO lecturers (name, phone, gender, email, department, password) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameters to the placeholders
    // 'ssssss' means all 6 variables are strings
    $stmt->bind_param("ssssss", $name, $phone, $gender, $email, $department, $password);

    // Execute the query
    if ($stmt->execute()) {
        echo "Lecturer registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Registration</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e90ff, #00bcd4);
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .registration-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        .registration-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1e90ff;
            font-weight: bold;
        }

        .form-control:focus {
            border-color: #1e90ff;
            box-shadow: none;
        }

        .btn-primary {
            background: #1e90ff;
            border: none;
        }

        .btn-primary:hover {
            background: #0077b6;
        }
    </style>
</head>

<body>
    <!-- <div class="registration-container">
        <h2>Lecturer Registration</h2> -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lecturer Registration</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                background: linear-gradient(135deg, #1e90ff, #00bcd4);
                font-family: Arial, sans-serif;
                height: 100vh;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .registration-container {
                background: #ffffff;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 600px;
            }

            .registration-container h2 {
                text-align: center;
                margin-bottom: 30px;
                color: #1e90ff;
                font-weight: bold;
            }

            form {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            form .form-group {
                display: flex;
                flex-direction: column;
            }

            .form-control:focus {
                border-color: #1e90ff;
                box-shadow: none;
            }

            button {
                height: 40px;
                color: white;
            }

            input {
                padding: 5px;
                border-radius: 5px;
                margin-top: 2px;

            }

            .btn-primary {
                background: #1e90ff;
                border: none;
            }

            .btn-primary:hover {
                background: #0077b6;
            }

            @media screen and (max-width: 768px) {
                form {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>

    <body>
        <div class="registration-container">
            <h2>Lecturer Registration</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone No</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                </div>
                <div class="form-group">
                    <label for="department" class="form-label">Department</label>
                    <select id="department" name="department" class="form-select" required>
                        <option value="" disabled selected>Select department</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Mathematics">Mathematics</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </div>
                <p class="text-center">
                    <a href="lecturer_login.php" class="text-primary">Already have an account? Login here</a>
                </p>
            </form>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>