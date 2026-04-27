<?php include('../layout/header.php'); ?>
<?php include('../layout/sidebar.php'); ?>

<div class="topbar mb-4">
    <h3>Enroll Participant</h3>
</div>

<form method="POST" class="card stat-card p-4">

    <div class="mb-3">
        <label>Participant</label>
        <select name="participant_id" class="form-control" required>
            <option value="">-- Select Participant --</option>
            <?php
            $participants = $conn->query("SELECT * FROM participants");
            while($row = $participants->fetch_assoc()) {
                echo "<option value='{$row['participant_id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Course</label>
        <select name="course_id" class="form-control" required>
            <option value="">-- Select Course --</option>
            <?php
            $courses = $conn->query("SELECT * FROM courses");
            while($row = $courses->fetch_assoc()) {
                echo "<option value='{$row['course_id']}'>{$row['course_name']}</option>";
            }
            ?>
        </select>
    </div>

    <button class="btn btn-warning">Enroll</button>

</form>

<?php
if ($_POST) {
    $pid = $_POST['participant_id'];
    $cid = $_POST['course_id'];

    $check = $conn->query("
        SELECT * FROM enrollment 
        WHERE participant_id = $pid AND course_id = $cid
    ");

    if ($check->num_rows > 0) {
        echo "<div class='alert alert-danger mt-3'>Already enrolled!</div>";
    } else {
        $conn->query("
            INSERT INTO enrollment (participant_id, course_id, enrollment_date)
            VALUES ($pid, $cid, NOW())
        ");

        echo "<div class='alert alert-success mt-3'>Enrollment success!</div>";
    }
}
?>

<?php include('../layout/footer.php'); ?>