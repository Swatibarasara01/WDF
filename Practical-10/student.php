<?php
require "auth.php";

if ($_SESSION["role"] !== "student") {
    http_response_code(403);
    exit("Access Denied: Student only.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Student Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!</p>
    <p>You are logged in as Student.</p>
    <a href="logout.php">
        <button type="button">Logout</button>
    </a>
</div>
</body>
</html>