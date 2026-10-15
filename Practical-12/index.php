<?php
include 'db.php';

$sql = "SELECT * FROM events ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f6f9;
        }

        h2 {
            text-align: center;
            color: #1d3557;
        }

        .add-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #1d3557;
            color: white;
        }

        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .edit-btn {
            color: white;
            background-color: #0d6efd;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete-btn {
            color: white;
            background-color: #dc3545;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>

<body>

    <h2>Event Management System</h2>

    <a href="add_event.php" class="add-btn">+ Add New Event</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Status</th>
            <th>Poster</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr>
                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['title']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['description'] ?? ''); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['event_date']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['status']); ?>
                    </td>

                    <td>
                        <?php
                        $posterPath = __DIR__ . '/uploads/'
                                    . basename($row['poster'] ?? '');

                        if (!empty($row['poster']) && is_file($posterPath)) {
                        ?>
                            <img
                                src="uploads/<?php echo rawurlencode(basename($row['poster'])); ?>"
                                alt="Event Poster">
                        <?php
                        } else {
                            echo "No poster available";
                        }
                        ?>
                    </td>

                    <td>
                        <a
                            href="edit_event.php?id=<?php echo (int)$row['id']; ?>"
                            class="edit-btn">
                            Edit
                        </a>
                    </td>

                    <td>
                        <a
                            href="delete_event.php?id=<?php echo (int)$row['id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this event?');">
                            Delete
                        </a>
                    </td>
                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="8" class="empty">
                    No events found.
                </td>
            </tr>

        <?php } ?>

    </table>

</body>
</html>