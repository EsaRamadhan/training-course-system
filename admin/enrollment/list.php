<?php include('../layout/header.php'); ?>
<?php include('../layout/sidebar.php'); ?>

<div class="content p-4">

    <div class="topbar mb-4">
        <h3>Enrollment Management</h3>
    </div>

    <div class="card stat-card p-4">

        <table class="table text-white">
            <tr>
            <th>User</th>
            <th>Course</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT 
    enrollment.*, 
    participants.name, 
    courses.course_name,
    payments.payment_id
FROM enrollment
JOIN participants ON enrollment.participant_id = participants.participant_id
JOIN courses ON enrollment.course_id = courses.course_id
LEFT JOIN payments ON enrollment.enrollment_id = payments.enrollment_id";

            $result = $conn->query($sql);

            if (!$result) {
                echo "<tr><td colspan='4'>Query Error</td></tr>";
            } elseif ($result->num_rows == 0) {
                echo "<tr><td colspan='4' class='text-center'>No enrollment data</td></tr>";
            } else {
                while($row = $result->fetch_assoc()) {
?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['course_name'] ?></td>
    <td><?= $row['enrollment_date'] ?></td>

    <!-- STATUS -->
    <td>
        <?php if ($row['payment_id']) { ?>
            <span class="badge bg-success">Paid</span>
        <?php } else { ?>
            <span class="badge bg-danger">Unpaid</span>
        <?php } ?>
    </td>

    <!-- ACTION -->
    <td>
        <?php if (!$row['payment_id']) { ?>
            <a href="../payments/pay.php?eid=<?= $row['enrollment_id'] ?>" 
               class="btn btn-success btn-sm">Mark Paid</a>
        <?php } ?>

        <a href="edit.php?id=<?= $row['enrollment_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete.php?id=<?= $row['enrollment_id'] ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this enrollment?')">
           Delete
        </a>
    </td>
</tr>
<?php
}
            }
            ?>
        </table>

    </div>

</div>

<?php include('../layout/footer.php'); ?>