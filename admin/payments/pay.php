<?php
include('../layout/header.php');
include('../layout/sidebar.php');

if (isset($_GET['eid'])) {
    $eid = $_GET['eid'];

    // check if already paid
    $check = $conn->query("SELECT * FROM payments WHERE enrollment_id = $eid");

    if ($check->num_rows > 0) {
        echo "<div class='alert alert-danger'>Already paid</div>";
    } else {
        $conn->query("
            INSERT INTO payments (enrollment_id, amount, payment_date)
            VALUES ($eid, 100000, NOW())
        ");

        echo "<div class='alert alert-success'>Payment marked as PAID</div>";
    }
}

echo "<a href='../enrollment/list.php' class='btn btn-light mt-3'>Back</a>";

include('../layout/footer.php');
?>