<?php
require "db.php";

$users = [
    [
        "name" => "Admin User",
        "email" => "admin@example.com",
        "password" => "Admin@123",
        "role" => "admin"
    ],
    [
        "name" => "Student User",
        "email" => "student@example.com",
        "password" => "Student@123",
        "role" => "student"
    ]
];

$stmt = $connection->prepare(
    "INSERT INTO users (name, email, password, role)
     VALUES (?, ?, ?, ?)"
);

foreach ($users as $user) {
    $name = $user["name"];
    $email = $user["email"];
    $password = password_hash(
        $user["password"],
        PASSWORD_DEFAULT
    );
    $role = $user["role"];

    $stmt->bind_param(
        "ssss",
        $name,
        $email,
        $password,
        $role
    );

    if ($stmt->execute()) {
        echo htmlspecialchars($email) . " created successfully.<br>";
    } else {
        echo htmlspecialchars($email) . " already exists or could not be created.<br>";
    }
}

$stmt->close();
$connection->close();
?>