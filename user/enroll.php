<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION['user'];
$pid = $user['participant_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enroll Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container mt-5">

<h2 class="text-white mb-4">Enroll Course</h2>

<div class="row">

<?php
// ambil semua course
$courses = $conn->query("
SELECT 
    courses.*, 
    instructors.name AS instructor_name,
    instructors.expertise
FROM courses
LEFT JOIN instructors ON courses.instructor_id = instructors.instructor_id
WHERE courses.course_id NOT IN (
    SELECT course_id FROM enrollment WHERE participant_id = $pid
)
");

while($row = $courses->fetch_assoc()) {

$levelClass = ($row['level'] == 'Beginner') ? 'beginner' : 'intermediate';

echo "
<div class='col-md-4 mb-4'>
    <div class='card course-card p-4'>

        <h5 class='mb-2'>{$row['course_name']}</h5>

        <span class='badge badge-level $levelClass'>
            {$row['level']}
        </span>

        <p class='price mt-2'>Rp " . number_format($row['price']) . "</p>

        <p class='text-light small'>
    Instructor: {$row['instructor_name']} <br>
    <span style='font-size:12px; opacity:0.7'>
        Expert in {$row['expertise']}
    </span>
</p>

        <form method='POST'>
            <input type='hidden' name='course_id' value='{$row['course_id']}'>
            <button class='btn btn-warning w-100 mt-3'>
                Enroll Now
            </button>
        </form>

    </div>
</div>
";
}
?>

</div>

<?php
// proses enroll
if ($_POST) {
    $cid = $_POST['course_id'];

    // check if already enrolled
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

<a href="dashboard.php" class="btn btn-light mt-4">Back</a>

</div>

</body>
</html>