<?php include('../layout/header.php'); ?>
<?php include('../layout/sidebar.php'); ?>

<div class="topbar mb-4">
    <h3>Payment Management</h3>
</div>

<div class="card stat-card p-4">

    <table class="table text-white">
        <tr>
            <th>User</th>
            <th>Course</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT 
            enrollment.enrollment_id,
            participants.name,
            courses.course_name,
            payments.payment_id,
            payments.amount,
            payments.payment_date
        FROM enrollment
        JOIN participants ON enrollment.participant_id = participants.participant_id
        JOIN courses ON enrollment.course_id = courses.course_id
        LEFT JOIN payments ON enrollment.enrollment_id = payments.enrollment_id";

        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "<tr><td colspan='6' class='text-center'>No data</td></tr>";
        }

        while($row = $result->fetch_assoc()) {

            echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['course_name']}</td>
                <td>";

            if ($row['amount']) {
                echo "Rp " . number_format($row['amount']);
            } else {
                echo "-";
            }

            echo "</td>
                <td>";

            if ($row['payment_date']) {
                echo $row['payment_date'];
            } else {
                echo "-";
            }

            echo "</td>
                <td>";

            if ($row['payment_id']) {
                echo "<span class='badge bg-success'>Paid</span>";
            } else {
                echo "<span class='badge bg-danger'>Unpaid</span>";
            }

            echo "</td>
                <td>";

            if (!$row['payment_id']) {
                echo "<a href='pay.php?eid={$row['enrollment_id']}' 
                        class='btn btn-success btn-sm'>Approve</a> ";
            } else {
                echo "<a href='delete.php?id={$row['payment_id']}' 
                        class='btn btn-danger btn-sm'
                        onclick=\"return confirm('Delete payment?')\">Delete</a>";
            }

            echo "</td></tr>";
        }
        ?>

    </table>

</div>

<?php include('../layout/footer.php'); ?>