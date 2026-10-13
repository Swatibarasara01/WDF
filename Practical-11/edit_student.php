<?php
require_once "db.php";

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Invalid student ID.");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$student) {
    die("Student not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $phone = trim($_POST['phone']);

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || $course === "" || !preg_match('/^[0-9]{10}$/', $phone)) {
        $message = "Please enter valid details.";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE students SET name=?, email=?, course=?, phone=? WHERE id=?"
        );

        mysqli_stmt_bind_param(
            $stmt, "ssssi", $name, $email, $course, $phone, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?updated=1");
            exit;
        } else {
            $message = "Update failed.";
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student Details</h2>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">
        Name:<br>
        <input type="text" name="name"
        value="<?php echo htmlspecialchars($student['name']); ?>" required>
        <br><br>

        Email:<br>
        <input type="email" name="email"
        value="<?php echo htmlspecialchars($student['email']); ?>" required>
        <br><br>

        Course:<br>
        <input type="text" name="course"
        value="<?php echo htmlspecialchars($student['course']); ?>" required>
        <br><br>

        Phone:<br>
        <input type="text" name="phone" pattern="[0-9]{10}"
        maxlength="10"
        value="<?php echo htmlspecialchars($student['phone']); ?>" required>
        <br><br>

        <button type="submit">Update Student</button>
    </form>

    <p><a href="index.php">Back to Student List</a></p>
</body>
</html>

<?php mysqli_close($conn); ?>