<?php
require "auth.php";

if ($_SESSION["role"] !== "admin") {
    http_response_code(403);
    exit("Access Denied: Admin only.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!</p>
    <p>You are logged in as Admin.</p>
    <a href="logout.php">
        <button type="button">Logout</button>
    </a>
</div>
</body>
</html>