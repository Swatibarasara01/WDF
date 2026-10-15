<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $status = $_POST['status'];

    if ($title == "" || $event_date == "") {
        $message = "Please enter event title and date.";
    } elseif (
        !isset($_FILES['poster']) ||
        $_FILES['poster']['error'] !== UPLOAD_ERR_OK
    ) {
        $message = "Please select a poster image.";
    } else {
        $file = $_FILES['poster'];
        $maxSize = 2 * 1024 * 1024;

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fileInfo->file($file['tmp_name']);

        if ($file['size'] > $maxSize) {
            $message = "Poster must be smaller than 2 MB.";
        } elseif (!isset($allowedTypes[$mimeType])) {
            $message = "Only JPG and PNG images are allowed.";
        } else {
            $uploadDir = __DIR__ . '/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = bin2hex(random_bytes(16))
                      . '.' . $allowedTypes[$mimeType];

            $destination = $uploadDir . $fileName;

            if (move_uploaded_file(
                $file['tmp_name'], $destination
            )) {
                $sql = "INSERT INTO events
                    (title, description, event_date, status, poster)
                    VALUES (?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param(
                    $stmt, "sssss",
                    $title, $description, $event_date,
                    $status, $fileName
                );

                if (mysqli_stmt_execute($stmt)) {
                    $message = "Event and poster added successfully!";
                } else {
                    unlink($destination);
                    $message = "Database error while saving event.";
                }

                mysqli_stmt_close($stmt);
            } else {
                $message = "Poster upload failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
</head>
<body>

<h2>Add New Event</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<form method="POST" action="add_event.php"
      enctype="multipart/form-data">

    <label>Event Title:</label><br>
    <input type="text" name="title" required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea>
    <br><br>

    <label>Event Date:</label><br>
    <input type="date" name="event_date" required>
    <br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="Open">Open</option>
        <option value="Closed">Closed</option>
    </select>
    <br><br>

    <label>Upload Poster (JPG/PNG, max 2 MB):</label><br>
    <input type="file" name="poster"
           accept=".jpg,.jpeg,.png" required>
    <br><br>

    <button type="submit">Add Event</button>

</form>

</body>
</html>