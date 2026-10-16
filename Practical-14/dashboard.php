<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalStudents = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();
$totalEvents = $conn->query("SELECT COUNT(*) FROM events")->fetchColumn();
$totalRegistrations = $conn->query("SELECT COUNT(*) FROM registrations")->fetchColumn();

$stmt = $conn->query(
    "SELECT s.name AS student_name, e.title AS event_title,
            r.registered_at
     FROM registrations r
     LEFT JOIN students s ON r.student_id = s.id
     LEFT JOIN events e ON r.event_id = e.id
     ORDER BY r.id DESC
     LIMIT 5"
);
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$logs = $conn->query(
    "SELECT action, details, created_at
     FROM audit_logs
     ORDER BY id DESC
     LIMIT 5"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
    <div class="text-white">
        Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>
        <a href="logout.php" class="btn btn-danger btn-sm ms-3">Logout</a>
    </div>
</nav>

<div class="container-fluid mt-4">
    <div class="row">
        <aside class="col-md-2 mb-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item active">Dashboard</a>
                <a href="#users" class="list-group-item">Users</a>
                <a href="#students" class="list-group-item">Students</a>
                <a href="#events" class="list-group-item">Events</a>
                <a href="#registrations" class="list-group-item">Registrations</a>
                <a href="#audit" class="list-group-item">Audit Logs</a>
            </div>
        </aside>

        <main class="col-md-10">
            <h2 class="mb-4">Dashboard Overview</h2>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5>Total Users</h5>
                            <h2><?= (int)$totalUsers ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5>Total Students</h5>
                            <h2><?= (int)$totalStudents ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5>Total Events</h5>
                            <h2><?= (int)$totalEvents ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5>Registrations</h5>
                            <h2><?= (int)$totalRegistrations ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <section id="registrations" class="card mb-4">
                <div class="card-header fw-bold">Recent Registrations</div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Event</th>
                            <th>Registered At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!$registrations): ?>
                            <tr><td colspan="3">No registrations found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($registrations as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r["student_name"] ?? "Unknown") ?></td>
                                    <td><?= htmlspecialchars($r["event_title"] ?? "Unknown") ?></td>
                                    <td><?= htmlspecialchars($r["registered_at"] ?? "") ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="audit" class="card mb-4">
                <div class="card-header fw-bold">Recent Audit Logs</div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Details</th>
                            <th>Date & Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!$logs): ?>
                            <tr><td colspan="3">No audit logs found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?= htmlspecialchars($log["action"]) ?></td>
                                    <td><?= htmlspecialchars($log["details"] ?? "") ?></td>
                                    <td><?= htmlspecialchars($log["created_at"] ?? "") ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</div>

</body>
</html>