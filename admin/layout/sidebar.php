<div class="sidebar p-3">
    <h4 class="logo">CourseSys</h4>
    <hr>

    <a href="../dashboard.php" class="menu">Dashboard</a>
    <a href="../participants/create.php" class="menu">+ Add Participant</a>
    <a href="../participants/list.php" class="menu">View Participants</a>
    <a href="../enrollment/list.php" class="menu">Enrollment</a>
    <a href="../payments/list.php" class="menu">Payments</a>
</div>

<div class="content p-4 w-100">

    <div class="topbar mb-4 d-flex justify-content-between align-items-center">
        <h4>Admin Panel</h4>

        <div>
            <span class="me-3 text-white">
                <?= $_SESSION['user']['name']; ?>
            </span>
            <a href="../../logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>