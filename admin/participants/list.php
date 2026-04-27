<?php include('../../config/db.php'); ?>
<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

require_once(__DIR__ . '/../../config/db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Participants List</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Participants</h2>

<table class="table table-bordered table-striped shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>

    <tbody>
    <?php
    $result = $conn->query("SELECT * FROM participants");

    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['participant_id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
        </tr>";
    }
    ?>
    </tbody>
</table>

</div>

</body>
</html>