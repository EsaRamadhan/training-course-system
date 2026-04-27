<?php include('../layout/header.php'); ?>
<?php include('../layout/sidebar.php'); ?>

<?php
$id = $_GET['id'];

// ambil data enrollment
$data = $conn->query("SELECT * FROM enrollment WHERE enrollment_id = $id")->fetch_assoc();

// ambil participant
$participants = $conn->query("SELECT * FROM participants");

// ambil course
$courses = $conn->query("SELECT * FROM courses");
?>

<h3>Edit Enrollment</h3>

<form method="POST" class="mt-3">

    <div class="mb-3">
        <label>User</label>
        <select name="participant_id" class="form-control">
            <?php while($p = $participants->fetch_assoc()) { ?>
                <option value="<?= $p['participant_id'] ?>"
                    <?= $p['participant_id'] == $data['participant_id'] ? 'selected' : '' ?>>
                    <?= $p['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Course</label>
        <select name="course_id" class="form-control">
            <?php while($c = $courses->fetch_assoc()) { ?>
                <option value="<?= $c['course_id'] ?>"
                    <?= $c['course_id'] == $data['course_id'] ? 'selected' : '' ?>>
                    <?= $c['course_name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <button class="btn btn-success">Update</button>

</form>

<?php
if ($_POST) {
    $pid = $_POST['participant_id'];
    $cid = $_POST['course_id'];

    $conn->query("UPDATE enrollment 
                  SET participant_id = $pid, course_id = $cid
                  WHERE enrollment_id = $id");

    echo "<div class='alert alert-success mt-3'>Updated!</div>";
}
?>

<?php include('../layout/footer.php'); ?>