<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

    <h2>Student Registration Form</h2>

    <form action="add_student.php" method="POST">
        <label>Student Name:</label><br>
        <input type="text" name="name" required>
        <br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Course:</label><br>
        <input type="text" name="course" required>
        <br><br>

        <label>Phone Number:</label><br>
        <input type="text" name="phone"
               pattern="[0-9]{10}"
               maxlength="10" required>
        <br><br>

        <input type="submit" name="submit"
               value="Add Student">
    </form>

    <?php
    require_once "db.php";

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $course = trim($_POST['course']);
        $phone = trim($_POST['phone']);

        $sql = "INSERT INTO students (name, email, course, phone)
                VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt, "ssss",
                $name, $email, $course, $phone
            );

            if (mysqli_stmt_execute($stmt)) {
                echo "<p>Student added successfully!</p>";
            } else {
                echo "<p>Failed to add student.</p>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Unable to prepare the query.</p>";
        }
    }

    mysqli_close($conn);
    ?>

</body>
</html>