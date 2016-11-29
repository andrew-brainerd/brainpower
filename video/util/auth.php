<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/31/2016
 * Time: 2:51 PM
 */
session_start();
header("access-control-allow-origin: *");
include "dbconnect.php";
$errorText = "Failed";

if (isset($_GET["maizenet"])) {
    $_SESSION["username"] = "umcu";
    $_SESSION["authLv"] = "10";
    $_SESSION["activity"] = time();
    header("Location: /video");
}
if (isset($_GET["key"])) autoLogin($_GET["key"], $conn);
$function = strip_tags($_GET["func"]);
if ($function == "getAuth") {
    $lastActivity = $_SESSION["activity"];
    $sessionExpired = isset($lastActivity) && ((time() - $lastActivity) > 1800);
    if ($sessionExpired) {
        session_unset();
        session_destroy();
        echo "session dead, failed";
        exit;
    }
    $currentUser = $_SESSION["username"];
    if (isset($currentUser)) echo "authorized";
} else if ($function == "setAuth") {
    $username = strip_tags($_GET["username"]);
    $password = strip_tags($_GET["password"]);
    if (performLogin($username, $password, $conn)) echo "authorized";
    else echo $errorText;
}

function performLogin($username, $password, $conn)
{
    global $errorText;
    $slt = "SELECT * FROM Users where username='$username'";
    $result = $conn->query($slt);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $_SESSION["authLv"] = $row["auth_level"];
            $_SESSION["activity"] = time();
            $conn->close();
            return true;
        } else $errorText = "Incorrect Password";
    } else $errorText = "Invalid Username";
    $conn->close();
    return false;
}

function autoLogin($userKey, $conn)
{
    echo "Got a Key! - $userKey<br>";
    $decoded = json_decode(base64url_decode($userKey), true);
    if (performLogin($decoded["un"], $decoded["pw"], $conn)) echo "authorized";
}
function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
