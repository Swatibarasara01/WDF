<?php
$connection = new mysqli(
    "localhost",
    "root",
    "",
    "practical10"
);

if ($connection->connect_error) {
    die("Database connection failed.");
}

$connection->set_charset("utf8mb4");
?>