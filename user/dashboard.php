<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pid = $user['participant_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="d-flex">

    <!-- 🔥 SIDEBAR -->
    <div class="sidebar p-3">
        <h4 class="logo">Dashboard</h4>
        <hr>

        <a href="dashboard.php" class="menu">Dashboard</a>
        <a href="enroll.php" class="menu">Enroll Course</a>
        <a href="payment.php" class="menu">Payment</a>
        <a href="../logout.php" class="menu text-danger">Logout</a>
    </div>

    <!-- 🔥 CONTENT -->
    <div class="content p-4">

        <!-- TOPBAR -->
        <div class="topbar mb-4">
            <h4>Welcome, <?= $user['name'] ?></h4>
        </div>

        <?php
// total courses
$courses_count = $conn->query("
    SELECT COUNT(*) as total 
    FROM enrollment 
    WHERE participant_id = $pid
")->fetch_assoc()['total'];

// total schedule
$schedule_count = $conn->query("
    SELECT COUNT(DISTINCT schedule.schedule_id) as total 
    FROM schedule
    JOIN enrollment ON schedule.course_id = enrollment.course_id
    WHERE enrollment.participant_id = $pid
")->fetch_assoc()['total'];

// total payments
$payment_count = $conn->query("
    SELECT COUNT(*) as total 
    FROM payments
    JOIN enrollment ON payments.enrollment_id = enrollment.enrollment_id
    WHERE enrollment.participant_id = $pid
")->fetch_assoc()['total'];
?>

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card stat-card text-center">
            <div class="icon blue"><i class="fa-solid fa-book"></i></div>
            <h4><?= $courses_count ?></h4>
            <p>My Courses</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card text-center">
            <div class="icon green"><i class="fa-solid fa-calendar"></i></div>
            <h4><?= $schedule_count ?></h4>
            <p>Schedules</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stat-card text-center">
            <div class="icon orange"><i class="fa-solid fa-credit-card"></i></div>
            <h4><?= $payment_count ?></h4>
            <p>Payments</p>
        </div>
    </div>

</div>

        <!-- ================= COURSES ================= -->
        <div class="card stat-card mb-4">
            <h5>Your Courses</h5>

            <table class="table mt-3 text-white">
                <tr>
                    <th>Course</th>
                    <th>Enrollment Date</th>
                    <th>Status</th>
                </tr>

                <?php
               $sql = "SELECT 
    courses.course_name,
    enrollment.enrollment_date,
    payments.payment_id
FROM enrollment
JOIN courses ON enrollment.course_id = courses.course_id
LEFT JOIN payments ON enrollment.enrollment_id = payments.enrollment_id
WHERE enrollment.participant_id = $pid";
                $result = $conn->query($sql);

                if ($result->num_rows == 0) {
                    echo "<tr><td colspan='3' class='text-center'>No courses yet</td></tr>";
                }

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
    <td>{$row['course_name']}</td>
    <td>{$row['enrollment_date']}</td>
    <td>";
    
if ($row['payment_id']) {
    echo "<span class='badge bg-success'>Paid</span>";
} else {
    echo "<span class='badge bg-danger'>Unpaid</span>";
}

echo "</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- ================= SCHEDULE ================= -->
        <div class="card stat-card mb-4">
            <h5>Schedule</h5>

            <table class="table mt-3 text-white">
            <tr>
                <th>Course</th>
                <th>Instructor</th> <!-- ADD HERE -->
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
            </tr>

                <?php
                $sql = "SELECT DISTINCT
    courses.course_name, 
    instructors.name AS instructor_name,
    schedule.schedule_date, 
    schedule.schedule_time, 
    schedule.room
FROM schedule
JOIN courses ON schedule.course_id = courses.course_id
JOIN instructors ON schedule.instructor_id = instructors.instructor_id
JOIN enrollment ON enrollment.course_id = courses.course_id
WHERE enrollment.participant_id = $pid";

                $result = $conn->query($sql);

                if ($result->num_rows == 0) {
                    echo "<tr><td colspan='5' class='text-center'>No schedule available</td></tr>";
                }

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['course_name']}</td>
                        <td>{$row['instructor_name']}</td>
                        <td>{$row['schedule_date']}</td>
                        <td>{$row['schedule_time']}</td>
                        <td>{$row['room']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <!-- ================= PAYMENTS ================= -->
        <div class="card stat-card">
            <h5>Payments</h5>

            <table class="table mt-3 text-white">
                <tr>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>

                <?php
                $sql = "SELECT payments.amount, payments.payment_date
                        FROM payments
                        JOIN enrollment ON payments.enrollment_id = enrollment.enrollment_id
                        WHERE enrollment.participant_id = $pid";

                $result = $conn->query($sql);

                if ($result->num_rows == 0) {
                    echo "<tr><td colspan='2' class='text-center'>No payment yet</td></tr>";
                }

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['amount']}</td>
                        <td>{$row['payment_date']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

    </div>

</div>

</body>
</html>