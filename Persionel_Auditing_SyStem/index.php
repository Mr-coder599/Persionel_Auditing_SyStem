<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Auditing System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
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

        .splash-container {
            text-align: center;
            max-width: 600px;
            padding: 50px 30px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.5);
        }

        .splash-container h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffdd00;
            font-weight: bold;
        }

        .splash-container p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #ddd;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 20px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 30px;
            text-decoration: none;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background: #ff9800;
            border: none;
        }

        .btn-primary:hover {
            background: #e68900;
        }

        .btn-secondary {
            background: #28a745;
            border: none;
        }

        .btn-secondary:hover {
            background: #218838;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #ccc;
        }

        .footer a {
            color: #ffdd00;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <h1>Welcome to Personnel Auditing System</h1>
        <p>Manage and audit personnel with ease using our cutting-edge platform. Start by registering or logging in.</p>
        <div>
            <p>
                Akinpelu Oluwafemi S

                Hc20220206162

            </p><br>
            Supervised by MrsFabiyi <br><br>

            <a href="./Admin/admin_register.php" class="btn btn-primary">Register as Admin</a>
            <a href="./Admin/admin_login.php" class="btn btn-secondary">Login</a>
        </div>
        <div class="footer">
            © 2024 Personnel Auditing System | <a href="#">Privacy Policy</a>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>