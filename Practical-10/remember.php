<?php

function setRememberCookie($value, $expiresAt)
{
    setcookie("remember_me", $value, [
        "expires" => $expiresAt,
        "path" => "/Practical-10",
        "secure" => !empty($_SERVER["HTTPS"]) &&
                    $_SERVER["HTTPS"] !== "off",
        "httponly" => true,
        "samesite" => "Lax"
    ]);
}

function clearRememberCookie()
{
    setRememberCookie("", time() - 3600);
    unset($_COOKIE["remember_me"]);
}

function restoreRememberedUser($connection)
{
    if (isset($_SESSION["user_id"])) {
        return true;
    }

    if (empty($_COOKIE["remember_me"])) {
        return false;
    }

    $parts = explode(":", $_COOKIE["remember_me"], 2);

    if (
        count($parts) !== 2 ||
        !ctype_xdigit($parts[0]) ||
        !ctype_xdigit($parts[1])
    ) {
        clearRememberCookie();
        return false;
    }

    $selector = $parts[0];
    $validator = $parts[1];

    $stmt = $connection->prepare(
        "SELECT rt.user_id, rt.token_hash, rt.expires_at,
                u.name, u.role
         FROM remember_tokens rt
         JOIN users u ON u.id = rt.user_id
         WHERE rt.selector = ?
         LIMIT 1"
    );

    $stmt->bind_param("s", $selector);
    $stmt->execute();

    $result = $stmt->get_result();
    $token = $result->fetch_assoc();
    $stmt->close();

    if (
        !$token ||
        strtotime($token["expires_at"]) <= time() ||
        !hash_equals(
            $token["token_hash"],
            hash("sha256", $validator)
        )
    ) {
        clearRememberCookie();
        return false;
    }

    session_regenerate_id(true);

    $_SESSION["user_id"] = $token["user_id"];
    $_SESSION["name"] = $token["name"];
    $_SESSION["role"] = $token["role"];
    $_SESSION["last_activity"] = time();

    return true;
}
?>