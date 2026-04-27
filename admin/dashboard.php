<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- FIX PATH CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar p-3">
        <h4 class="logo">CourseSys</h4>
        <hr>

        <a href="participants/create.php" class="btn btn-premium btn-green">+ Add Participant</a>
        <a href="participants/list.php" class="btn btn-premium btn-blue">View Participants</a>
        <a href="enrollment/create.php" class="btn btn-premium btn-yellow">+ Enroll User</a>
        <a href="payments/list.php" class="btn btn-premium btn-red">View Payments</a>
    </div>

    <!-- MAIN -->
    <div class="content p-4">

        <!-- TOPBAR -->
        <div class="topbar mb-4 d-flex justify-content-between align-items-center">
            <h3>Dashboard</h3>

            <div>
                <span class="me-3 text-white">
                    <?= $_SESSION['user']['name']; ?>
                </span>
                <!-- FIX PATH -->
                <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
            </div>
        </div>

        <!-- STATS CARDS (CLICKABLE) -->
        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <a href="participants/list.php" class="text-decoration-none">
                    <div class="card stat-card">
                        <i class="fa fa-users icon blue"></i>
                        <h5>Participants</h5>
                        <p>Manage users</p>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="../user/enroll.php" class="text-decoration-none">
                    <div class="card stat-card">
                        <i class="fa fa-book icon green"></i>
                        <h5>Courses</h5>
                        <p>All courses</p>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="enrollment/list.php" class="text-decoration-none">
                    <div class="card stat-card">
                        <i class="fa fa-user-check icon orange"></i>
                        <h5>Enrollment</h5>
                        <p>Track students</p>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="payments/pay.php" class="text-decoration-none">
                    <div class="card stat-card">
                        <i class="fa fa-money-bill icon red"></i>
                        <h5>Payments</h5>
                        <p>Transactions</p>
                    </div>
                </a>
            </div>

        </div>

        <!-- HERO -->
        <div class="card hero-card mb-4">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <h2>Admin Control Panel</h2>
                    <p>Manage users, courses, enrollments, and payments efficiently.</p>
                </div>

                <div class="col-md-6 text-center">
                    <!-- FIX PATH -->
                    <img src="../assets/class.png" class="hero-img">
                </div>

            </div>
        </div>

        <!-- 🔥 QUICK ACTION -->
        <div class="mt-4">
            <a href="participants/create.php" class="btn btn-success">
    + Add Participant
</a>

<a href="enrollment/create.php" class="btn btn-warning">
    + Enroll to Course
</a>
        </div>

    </div>

</div>

</body>
</html>