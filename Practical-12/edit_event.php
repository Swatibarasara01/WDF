<?php
include 'db.php';

$message = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid event ID.");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM events WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$event = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$event) {
    exit("Event not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    $status = $_POST['status'] ?? '';

    if ($title === '' || $event_date === '') {
        $message = "Title and date are required.";
    } elseif (!in_array($status, ['Open', 'Closed'], true)) {
        $message = "Invalid status.";
    } else {
        $newPoster = $event['poster'];
        $uploadedPath = null;

        if (isset($_FILES['poster']) &&
            $_FILES['poster']['error'] !== UPLOAD_ERR_NO_FILE) {

            $file = $_FILES['poster'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $message = "Poster upload failed.";
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $message = "Poster must be smaller than 2 MB.";
            } else {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($file['tmp_name']);

                $types = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png'
                ];

                if (!isset($types[$mime])) {
                    $message = "Only JPG and PNG images are allowed.";
                } else {
                    $uploadDir = __DIR__ . '/uploads/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $newPoster = bin2hex(random_bytes(16))
                               . '.' . $types[$mime];
                    $uploadedPath = $uploadDir . $newPoster;

                    if (!move_uploaded_file(
                        $file['tmp_name'], $uploadedPath
                    )) {
                        $message = "Could not save the poster.";
                    }
                }
            }
        }

        if ($message === "") {
            $sql = "UPDATE events
                    SET title = ?, description = ?,
                        event_date = ?, status = ?, poster = ?
                    WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param(
                $stmt, "sssssi",
                $title, $description, $event_date,
                $status, $newPoster, $id
            );

            if (mysqli_stmt_execute($stmt)) {
                if ($uploadedPath !== null &&
                    !empty($event['poster'])) {
                    $oldPath = __DIR__ . '/uploads/'
                             . basename($event['poster']);

                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }

                header("Location: index.php");
                exit;
            } else {
                if ($uploadedPath !== null &&
                    is_file($uploadedPath)) {
                    unlink($uploadedPath);
                }

                $message = "Error updating event.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>

<h2>Edit Event</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<form method="POST" enctype="multipart/form-data">

    <label>Event Title:</label><br>
    <input type="text" name="title"
        value="<?php echo htmlspecialchars($event['title']); ?>"
        required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="description"><?php
        echo htmlspecialchars($event['description'] ?? '');
    ?></textarea>
    <br><br>

    <label>Event Date:</label><br>
    <input type="date" name="event_date"
        value="<?php echo htmlspecialchars($event['event_date']); ?>"
        required>
    <br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="Open"
            <?php if ($event['status'] === 'Open') echo 'selected'; ?>>
            Open
        </option>
        <option value="Closed"
            <?php if ($event['status'] === 'Closed') echo 'selected'; ?>>
            Closed
        </option>
    </select>
    <br><br>

    <label>Current Poster:</label><br>

    <?php if (!empty($event['poster']) &&
        is_file(__DIR__ . '/uploads/' . basename($event['poster']))) { ?>
        <img
            src="uploads/<?php echo rawurlencode(basename($event['poster'])); ?>"
            width="120" alt="Current poster">
    <?php } else { ?>
        No poster available
    <?php } ?>

    <br><br>

    <label>Choose New Poster (optional, JPG/PNG, max 2 MB):</label><br>
    <input type="file" name="poster" accept=".jpg,.jpeg,.png">
    <br><br>

    <button type="submit">Update Event</button>

</form>

<br>
<a href="index.php">Back to Events</a>

</body>
</html>