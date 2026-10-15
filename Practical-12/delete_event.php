```php
<?php
include 'db.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Invalid event ID.");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM events WHERE id = ? LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) === 1) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    } else {
        echo "Event not found.";
    }
} else {
    echo "Delete failed: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
```