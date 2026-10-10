<?php
session_start();

require "db.php";
require "remember.php";

$error = "";

if (isset($_SESSION["user_id"])) {
    header(
        "Location: " .
        ($_SESSION["role"] === "admin"
            ? "admin.php"
            : "student.php")
    );
    exit;
}

if (restoreRememberedUser($connection)) {
    header(
        "Location: " .
        ($_SESSION["role"] === "admin"
            ? "admin.php"
            : "student.php")
    );
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Please enter email and password.";
    } else {
        $stmt = $connection->prepare(
            "SELECT id, name, email, password, role
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        if (
            $user &&
            password_verify($password, $user["password"])
        ) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["last_activity"] = time();

            $updateLogin = $connection->prepare(
                "UPDATE users
                 SET last_login = NOW()
                 WHERE id = ?"
            );

            $updateLogin->bind_param("i", $user["id"]);
            $updateLogin->execute();
            $updateLogin->close();

            if (isset($_POST["remember_me"])) {
                $selector = bin2hex(random_bytes(16));
                $validator = bin2hex(random_bytes(32));

                $tokenHash = hash("sha256", $validator);

                $expiresAt = time() + (30 * 24 * 60 * 60);

                $expiresAtDB = date(
                    "Y-m-d H:i:s",
                    $expiresAt
                );

                $tokenStmt = $connection->prepare(
                    "INSERT INTO remember_tokens
                    (user_id, selector, token_hash, expires_at)
                    VALUES (?, ?, ?, ?)"
                );

                $tokenStmt->bind_param(
                    "isss",
                    $user["id"],
                    $selector,
                    $tokenHash,
                    $expiresAtDB
                );

                if ($tokenStmt->execute()) {
                    setRememberCookie(
                        $selector . ":" . $validator,
                        $expiresAt
                    );
                }

                $tokenStmt->close();
            }

            $connection->close();

            if ($user["role"] === "admin") {
                header("Location: admin.php");
            } else {
                header("Location: student.php");
            }

            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Secure Login</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Secure Login</h2>

    <?php if ($error !== ""): ?>
        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET["timeout"])): ?>
        <p class="error">
            Session expired. Please log in again.
        </p>
    <?php endif; ?>

    <?php if (isset($_GET["logout"])): ?>
        <p>
            You have logged out successfully.
        </p>
    <?php endif; ?>

    <form method="POST" action="login.php">

        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <p>
            <input
                type="checkbox"
                name="remember_me"
                value="1"
                style="width: auto;"
            >
            Remember Me
        </p>

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>