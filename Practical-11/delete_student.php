<?php
require_once "db.php";

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    mysqli_close($conn);
    header("Location: index.php?error=1");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) === 1) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: index.php?deleted=1");
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: index.php?error=1");
exit;
?>