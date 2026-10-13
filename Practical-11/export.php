<?php
require_once "db.php";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=students.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["ID", "Name", "Email", "Course", "Phone"]);

$sql = "SELECT id, name, email, course, phone
        FROM students ORDER BY id ASC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row["id"],
        $row["name"],
        $row["email"],
        $row["course"],
        $row["phone"]
    ]);
}

fclose($output);
mysqli_close($conn);
exit;
?>