<?php
session_start();
include('config/db.php');

if ($_POST) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);
    $role = "user";

    // 🔍 CHECK EMAIL EXISTS
    $check = $conn->query("SELECT * FROM participants WHERE email='$email'");

    if ($check->num_rows > 0) {
        echo "<div class='alert alert-danger text-center'>Email already registered!</div>";
    } else {

        // ✅ INSERT DATA
        $sql = "INSERT INTO participants 
        (name, email, password, role, registration_date)
        VALUES ('$name', '$email', '$pass', '$role', NOW())";

        if ($conn->query($sql)) {

            // 🔥 AUTO LOGIN
            $result = $conn->query("SELECT * FROM participants WHERE email='$email'");
            $user = $result->fetch_assoc();

            $_SESSION['user'] = $user;

            header("Location: user/dashboard.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top, #1e3c72, #0f172a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI';
        }

        .glass-card {
            width: 380px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            color: white;
        }

        .form-control {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: #cbd5e1;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.15);
            box-shadow: none;
            color: white;
        }

        .btn-register {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 12px;
            font-weight: bold;
        }

        .btn-register:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        }

        a {
            color: #60a5fa;
        }
    </style>
</head>

<body>

<div class="glass-card">

    <h3 class="text-center mb-4">Create Account</h3>

    <form method="POST">

        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
        </div>

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button class="btn btn-register w-100">Register</button>

    </form>

    <p class="text-center mt-3">
        Already have account? <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>