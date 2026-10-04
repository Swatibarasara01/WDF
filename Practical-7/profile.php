<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studentId = trim($_POST["studentId"]);
    $name = trim($_POST["name"]);
    $department = trim($_POST["department"]);
    $semester = trim($_POST["semester"]);
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);

    if ($studentId == "" || $name == "" || $department == "" ||
        $semester == "" || $email == "" || $mobile == "") {

        echo "Please fill all fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email.";
        exit;
    }

    if (!preg_match("/^[6-9][0-9]{9}$/", $mobile)) {
        echo "Invalid Mobile Number.";
        exit;
    }

    $file = "profiles.csv";

    $handle = fopen($file, "a");

    if ($handle === false) {
        echo "Unable to create CSV file.";
        exit;
    }

    if (filesize($file) == 0) {

        fputcsv($handle, array(
            "Student ID",
            "Name",
            "Department",
            "Semester",
            "Email",
            "Mobile"
        ));
    }

    fputcsv($handle, array(
        $studentId,
        $name,
        $department,
        $semester,
        $email,
        $mobile
    ));

    fclose($handle);

    echo "<h2>Profile Saved Successfully!</h2>";
    echo "<p>Your profile data has been saved in profiles.csv</p>";
    echo "<a href='profile.html'>Go Back</a>";

} else {

    echo "Invalid Request.";

}

?>