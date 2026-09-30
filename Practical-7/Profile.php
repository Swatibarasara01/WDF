<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentname = trim($_POST["studentname"] ?? "");
    $studentid   = trim($_POST["studentid"] ?? "");
    $department  = trim($_POST["department"] ?? "");
    $semester    = trim($_POST["semester"] ?? "");
    $email       = trim($_POST["email"] ?? "");

    $errors = [];

    if (empty($studentname)) {
        $errors[] = "Student Name is required.";
    }

    if (empty($studentid)) {
        $errors[] = "Student ID is required.";
    }

    if (empty($department)) {
        $errors[] = "Department is required.";
    }

    if (empty($semester)) {
        $errors[] = "Semester is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if (!empty($errors)) {

        $message = "<div style='color:red;'>";
        foreach ($errors as $error) {
            $message .= "<p>$error</p>";
        }
        $message .= "</div>";

    } else {

        $file = "students.csv";
        $handle = fopen($file, "a");

        if ($handle !== false) {
            
            if (filesize($file) == 0) {
                fputcsv($handle, [
                    "Student Name",
                    "Student ID",
                    "Department",
                    "Semester",
                    "Email"
                ]);
            }

            fputcsv($handle, [
                htmlspecialchars($studentname),
                htmlspecialchars($studentid),
                htmlspecialchars($department),
                htmlspecialchars($semester),
                htmlspecialchars($email)
            ]);

            fclose($handle);

            $message = "<p style='color:green;'>
                        Profile saved successfully!
                        </p>";

        } else {

            $message = "<p style='color:red;'>
                        Error: Unable to open CSV file.
                        </p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Profile</title>
</head>

<body>

<h2>Student Profile Form</h2>

<?php echo $message; ?>

<form method="POST" action="">

    <label>Student Name:</label>
    <input type="text" name="studentname">
    <br><br>

    <label>Student ID:</label>
    <input type="text" name="studentid">
    <br><br>

    <label>Department:</label>
    <input type="text" name="department">
    <br><br>

    <label>Semester:</label>
    <input type="text" name="semester">
    <br><br>

    <label>Email:</label>
    <input type="email" name="email">
    <br><br>

    <button type="submit">Save Profile</button>

</form>

</body>
</html>
