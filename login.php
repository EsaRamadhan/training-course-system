<?php 
session_start();
include('config/db.php'); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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

        .btn-login {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            border-radius: 12px;
            font-weight: bold;
        }

        .btn-login:hover {
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

    <h3 class="text-center mb-4">Login</h3>

    <form method="POST">

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button class="btn btn-login w-100">Login</button>

    </form>

<?php
if ($_POST) {

    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $sql = "SELECT * FROM participants 
            WHERE email='$email' AND password='$pass'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }
        exit();
    } else {
        echo "<div class='alert alert-danger mt-3 text-center'>Login failed!</div>";
    }
}
?>

    <p class="text-center mt-3">
        Don't have account? <a href="register.php">Register</a>
    </p>

</div>

</body>
</html>