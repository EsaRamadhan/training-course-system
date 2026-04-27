<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pid = $user['participant_id'];

// HANDLE PAYMENT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eid = $_POST['enrollment_id'];

    // check if already paid
    $check = $conn->query("SELECT * FROM payments WHERE enrollment_id = $eid");

    if ($check->num_rows == 0) {

        // ambil harga course
        $priceQuery = $conn->query("
            SELECT courses.price 
            FROM enrollment
            JOIN courses ON enrollment.course_id = courses.course_id
            WHERE enrollment.enrollment_id = $eid
        ");

        if ($priceQuery && $priceQuery->num_rows > 0) {
            $priceData = $priceQuery->fetch_assoc();
            $amount = $priceData['price'];

            // insert payment
            $conn->query("
                INSERT INTO payments (enrollment_id, amount, payment_date)
                VALUES ($eid, $amount, NOW())
            ");
        }
    }

    header("Location: payment.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar p-3">
        <h4 class="logo">User Panel</h4>
        <hr>

        <a href="dashboard.php" class="menu">Dashboard</a>
        <a href="enroll.php" class="menu">Enroll Course</a>
        <a href="payment.php" class="menu">Payment</a>
        <a href="../logout.php" class="menu text-danger">Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content p-4 w-100">

        <div class="topbar mb-4">
            <h4>Make Payment</h4>
        </div>

        <div class="card stat-card p-4">

            <table class="table text-white">
                <tr>
                    <th>Course</th>
                    <th>Enroll Date</th>
                    <th>Status</th>
                </tr>

                <?php
                $sql = "SELECT 
                        enrollment.enrollment_id, 
                        courses.course_name, 
                        enrollment.enrollment_date,
                        payments.payment_id
                        FROM enrollment
                        JOIN courses ON enrollment.course_id = courses.course_id
                        LEFT JOIN payments ON enrollment.enrollment_id = payments.enrollment_id
                        WHERE enrollment.participant_id = $pid";

                $result = $conn->query($sql);

                if ($result->num_rows == 0) {
                    echo "<tr><td colspan='3' class='text-center'>No enrollments found</td></tr>";
                }

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['course_name']}</td>
                        <td>{$row['enrollment_date']}</td>
                        <td>";

                    if ($row['payment_id']) {
                        echo "<span class='badge bg-success'>✔ Paid</span>";
                    } else {
                        echo "
                        <span class='badge bg-danger me-2'>Not Paid</span>
                        <form method='POST' style='display:inline'>
                            <input type='hidden' name='enrollment_id' value='{$row['enrollment_id']}'>
                            <button class='btn btn-warning btn-sm'>Pay Now</button>
                        </form>
                        ";
                    }

                    echo "</td></tr>";
                }
                ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>