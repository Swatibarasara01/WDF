<?php
require_once "db.php";

$search = trim($_GET['search'] ?? "");
$filterCourse = trim($_GET['course'] ?? "");

$sql = "SELECT * FROM students WHERE
        (name LIKE ? OR email LIKE ? OR course LIKE ?)";

$searchValue = "%" . $search . "%";

if ($filterCourse !== "") {
    $sql .= " AND course = ?";
}

$sql .= " ORDER BY id ASC";

$stmt = mysqli_prepare($conn, $sql);

if ($filterCourse !== "") {
    mysqli_stmt_bind_param(
        $stmt, "ssss",
        $searchValue, $searchValue, $searchValue, $filterCourse
    );
} else {
    mysqli_stmt_bind_param(
        $stmt, "sss",
        $searchValue, $searchValue, $searchValue
    );
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
</head>
<body>

    <h2>Student Management System</h2>

    <?php if (isset($_GET['updated'])) { ?>
        <p style="color:green;">Student updated successfully!</p>
    <?php } ?>

    <?php if (isset($_GET['deleted'])) { ?>
        <p style="color:green;">Student deleted successfully!</p>
    <?php } ?>

    <?php if (isset($_GET['error'])) { ?>
        <p style="color:red;">Unable to delete student.</p>
    <?php } ?>

    <a href="add_student.php">Add New Student</a>

    <h3>Search and Filter Students</h3>

    <form method="GET" action="index.php">

        <label>Search by Name, Email or Course:</label><br>

        <input type="text" name="search"
               placeholder="Enter name, email or course"
               value="<?php echo htmlspecialchars($search); ?>">

        <br><br>

        <label>Filter by Course:</label><br>

        <select name="course">
            <option value="">All Courses</option>

            <?php
            $coursesResult = mysqli_query(
                $conn,
                "SELECT DISTINCT course FROM students ORDER BY course"
            );

            while ($courseRow = mysqli_fetch_assoc($coursesResult)) {
                $courseName = $courseRow['course'];
                $selected = ($filterCourse === $courseName)
                    ? "selected" : "";
            ?>
                <option value="<?php echo htmlspecialchars($courseName); ?>"
                    <?php echo $selected; ?>>
                    <?php echo htmlspecialchars($courseName); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <button type="submit">Search / Filter</button>
        <a href="index.php">Reset</a>

    </form>

    <br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>

                <td>
                    <a href="edit_student.php?id=<?php echo $row['id']; ?>">
                        Edit
                    </a>
                    |
                    <a href="delete_student.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this student?');">
                        Delete
                    </a>
                </td>
            </tr>
            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="6">No students found.</td>
            </tr>

        <?php } ?>

    </table>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>