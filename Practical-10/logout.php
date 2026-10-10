<?php
session_start();

require "db.php";
require "remember.php";

if (!empty($_COOKIE["remember_me"])) {
    $parts = explode(":", $_COOKIE["remember_me"], 2);

    if (count($parts) === 2 && ctype_xdigit($parts[0])) {
        $selector = $parts[0];

        $stmt = $connection->prepare(
            "DELETE FROM remember_tokens WHERE selector = ?"
        );

        $stmt->bind_param("s", $selector);
        $stmt->execute();
        $stmt->close();
    }
}

clearRememberCookie();

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(session_name(), "", [
        "expires" => time() - 3600,
        "path" => $params["path"],
        "domain" => $params["domain"],
        "secure" => $params["secure"],
        "httponly" => $params["httponly"],
        "samesite" => $params["samesite"] ?? "Lax"
    ]);
}

session_destroy();

$connection->close();

header("Location: login.php?logout=1");
exit;
?>