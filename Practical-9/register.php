<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Please submit the registration form.");
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";

if (
    $name === "" ||
    $email === "" ||
    $username === "" ||
    $password === "" ||
    $confirm_password === ""
) {
    exit("Error: All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Error: Please enter a valid email address.");
}

if (strlen($name) > 100 || strlen($email) > 150) {
    exit("Error: Name or email is too long.");
}

if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
    exit("Error: Username must be 3-50 characters and contain only letters, numbers, or underscores.");
}

if (strlen($password) < 8) {
    exit("Error: Password must contain at least 8 characters.");
}

if ($password !== $confirm_password) {
    exit("Error: Passwords do not match.");
}

$check = $connection->prepare(
    "SELECT id FROM users WHERE email = ? OR username = ? LIMIT 1"
);

$check->bind_param("ss", $email, $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    $connection->close();
    exit("Error: Email or username already exists.");
}

$check->close();

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($hashed_password === false) {
    $connection->close();
    exit("Error: Password processing failed.");
}

$stmt = $connection->prepare(
    "INSERT INTO users (name, email, username, password)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssss",
    $name,
    $email,
    $username,
    $hashed_password
);

if ($stmt->execute()) {
    echo "<h2>Registration Successful!</h2>";
    echo "<p>Your account has been created successfully.</p>";
    echo '<a href="register.html">Register Another User</a>';
} else {
    if ($stmt->errno == 1062) {
        echo "Error: Email or username already exists.";
    } else {
        echo "Error: Registration could not be completed.";
    }
}

$stmt->close();
$connection->close();
?>