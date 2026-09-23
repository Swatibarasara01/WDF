<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $studentid = $_POST["studentid"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    // Phone validation
    if (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {

        echo "Invalid Phone Number. It must be 10 digits and start with 6-9.";
        exit;
    }

    // Password validation
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z0-9@$!%*?&]{8}$/", $password)) {

        echo "Invalid Password. Password must be exactly 8 characters and contain a letter, number and special character.";
        exit;
    }

    // CSV file
    $file = "registrations.csv";

    $handle = fopen($file, "a");

    // Add headings if file is empty
    if (filesize($file) == 0) {

        fputcsv($handle, [
            "Name",
            "Email ID",
            "Student ID",
            "Phone Number",
            "Password"
        ]);
    }

    // Save data
    fputcsv($handle, [
        $name,
        $email,
        $studentid,
        $phone,
        $password
    ]);

    fclose($handle);

    echo "Registration successful! Data saved.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Registration</title>
</head>

<body>

    <h1>Student Registration Form</h1>

    <form method="POST">

        <label>Name:</label>
        <input type="text" name="name" required>
        <br><br>

        <label>Email ID:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Student ID:</label>
        <input type="text" name="studentid" required>
        <br><br>

        <label>Phone Number:</label>
        <input type="text" name="phone" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <input type="submit" value="Register">

    </form>

</body>

</html>