<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/31/2016
 * Time: 2:51 PM
 */
session_start();
header("access-control-allow-origin: *");
echo "<div id='authResponse'>";
include "dbconnect.php";

// Only happens if session is gucci
$function = strip_tags($_GET["func"]);
if ($function == "getAuth") {
    $lastActivity = $_SESSION["activity"];
    $sessionExpired = isset($lastActivity) && ((time() - $lastActivity) > 1800);
    if ($sessionExpired) {
        session_unset();
        session_destroy();
        echo "<div id='authorization'>session dead, failed</div>";
        exit;
    }
    $currentUser = $_SESSION["username"];
    if (isset($currentUser)) echo "<div id='authorization' data-user='$currentUser'>authorized</div>";
    else echo "<div id='authorization'>failed</div>";
} else if ($function == "setAuth") {
    $loginInfo = $_GET["login"];
    if ($loginInfo == null) {
        $username = strip_tags($_GET["username"]);
        $password = strip_tags($_GET["password"]);
        if ($username . $password != "") {
            //echo "Username: " . $username . "<br />";
            //echo "Password: " . $password . "<br />";
            if (performLogin($username, $password, $conn)) echo "<div id='authorization' data-user='$username'>authorized</div>";
            else echo "<div id='authorization'>failed</div>";
        } else echo "Please provide a username and password<br />";
    } else echo "Login Info: " . $loginInfo . "<br />";
    $redirectPage = $_GET["redirectPage"];
    if ($redirectPage != null) echo "Redirect Page: " . $redirectPage . "<br />";
}
echo "<div>"; // end of authResponse
/*if (strpos($url, "?") > 0) {
    $params = substr($url, strpos($url, "?") + 1, strlen($url));
    $decoded = base64url_decode($params);
    $un = substr($decoded, strpos($decoded, "=") + 1, strpos($decoded, "&") - 2);
    $decoded2 = substr($decoded, strpos($decoded, "&"));
    $pw = substr($decoded2, strpos($decoded2, "=") + 1);
    if (strpos($pw, "&") > 0) {
        $vi = substr($pw, strpos($pw, "=") + 1);
        $pw = substr($pw, 0, strpos($pw, "&"));
    } else {
        $pw = substr($decoded2, strpos($decoded2, "=") + 1);
        $vi = "";
    }
    echo "Username: " . $un . "<br>";
    echo "Password: " . $pw . "<br>";
    echo "Video ID: " . $vi . "<br><br>";
}*/
function performLogin($username, $password, $conn)
{
    $slt = "SELECT * FROM Users where username='$username'";
    $result = $conn->query($slt);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $_SESSION["authLv"] = $row["auth_level"];
            $_SESSION['activity'] = time();
            if (isset($_SESSION["prevPage"]) && $_SESSION["prevPage"] != "") {
                $_SESSION["prevPage"] = "/video";
                echo "<div id='prevPage'>Set: " . $_SESSION["prevPage"] . "</div>";
                $_SESSION["prevPage"] = "";
            }
            $conn->close();
            return true;
        } else echo "<div id='loginError'>Incorrect Password</div>";
    } else echo "<div id='loginError'>Invalid Username</div>";
    $conn->close();
    return false;
}
function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
