<?php include('../../config/db.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Participant</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Add Participant</h2>

<form method="POST" class="card p-4 shadow">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <div class="mb-3">
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="">-- Select --</option>
            <option>Male</option>
            <option>Female</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Birth Date</label>
        <input type="date" name="dob" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>

</form>

<?php
if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];

    $sql = "INSERT INTO participants 
    (name, email, phone, gender, date_of_birth, registration_date)
    VALUES ('$name','$email','$phone','$gender','$dob', NOW())";

    $conn->query($sql);

    echo "<div class='alert alert-success mt-3'>Participant added!</div>";
}
?>

</div>

</body>
</html>