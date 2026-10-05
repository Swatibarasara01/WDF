<?php

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid Request. Please submit the profile form.");
}

$studentId = trim($_POST["studentId"] ?? "");
$name = trim($_POST["name"] ?? "");
$department = trim($_POST["department"] ?? "");
$semester = trim($_POST["semester"] ?? "");
$email = trim($_POST["email"] ?? "");
$mobile = trim($_POST["mobile"] ?? "");

if (
    $studentId === "" ||
    $name === "" ||
    $department === "" ||
    $semester === "" ||
    $email === "" ||
    $mobile === ""
) {
    die("Please fill all fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid Email.");
}

if (!preg_match("/^[6-9][0-9]{9}$/", $mobile)) {
    die("Invalid Mobile Number.");
}

try {

    $sql = "INSERT INTO students
            (student_id, name, department, semester, email, mobile)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $studentId,
        $name,
        $department,
        $semester,
        $email,
        $mobile
    ]);

    echo "<h2>Profile Saved Successfully!</h2>";
    echo "<p>Student data has been saved in MySQL database.</p>";
    echo "<a href='profile.html'>Go Back</a>";

} catch (PDOException $e) {

    echo "<h2>Database Error</h2>";
    echo "<p>Unable to save student data.</p>";

}

?>