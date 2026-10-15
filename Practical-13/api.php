<?php
header("Content-Type: application/json; charset=UTF-8");

function sendResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=practical13;charset=utf8mb4",
        "root",
        ""
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $method = $_SERVER["REQUEST_METHOD"];

    if ($method === "GET") {
        $stmt = $pdo->query(
            "SELECT id, name, email FROM students ORDER BY id DESC"
        );

        sendResponse([
            "success" => true,
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ]);
    }

    $input = json_decode(file_get_contents("php://input"), true);

    if (!is_array($input)) {
        sendResponse([
            "success" => false,
            "message" => "Invalid JSON data."
        ], 400);
    }

    if ($method === "POST" || $method === "PUT") {
        $name = trim($input["name"] ?? "");
        $email = trim($input["email"] ?? "");

        if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendResponse([
                "success" => false,
                "message" => "Enter a name and valid email."
            ], 422);
        }

        if ($method === "POST") {
            $stmt = $pdo->prepare(
                "INSERT INTO students (name, email) VALUES (?, ?)"
            );

            $stmt->execute([$name, $email]);

            sendResponse([
                "success" => true,
                "message" => "Student added successfully."
            ], 201);
        }

        $id = filter_var(
            $input["id"] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$id || $id < 1) {
            sendResponse([
                "success" => false,
                "message" => "Invalid student ID."
            ], 400);
        }

        $stmt = $pdo->prepare(
            "UPDATE students SET name = ?, email = ? WHERE id = ?"
        );

        $stmt->execute([$name, $email, $id]);

        if ($stmt->rowCount() === 0) {
            $check = $pdo->prepare(
                "SELECT id FROM students WHERE id = ?"
            );
            $check->execute([$id]);

            if (!$check->fetch()) {
                sendResponse([
                    "success" => false,
                    "message" => "Student not found."
                ], 404);
            }
        }

        sendResponse([
            "success" => true,
            "message" => "Student updated successfully."
        ]);
    }

    if ($method === "DELETE") {
        $id = filter_var(
            $input["id"] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!$id || $id < 1) {
            sendResponse([
                "success" => false,
                "message" => "Invalid student ID."
            ], 400);
        }

        $stmt = $pdo->prepare(
            "DELETE FROM students WHERE id = ?"
        );

        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            sendResponse([
                "success" => false,
                "message" => "Student not found."
            ], 404);
        }

        sendResponse([
            "success" => true,
            "message" => "Student deleted successfully."
        ]);
    }

    header("Allow: GET, POST, PUT, DELETE");

    sendResponse([
        "success" => false,
        "message" => "Method not allowed."
    ], 405);

} catch (Throwable $e) {
    error_log($e->getMessage());

    sendResponse([
        "success" => false,
        "message" => "Database or server error."
    ], 500);
}
?>