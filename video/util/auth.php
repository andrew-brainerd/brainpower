<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/31/2016
 * Time: 2:51 PM
 */

include "login.php";
include "dbconnect.php";
session_start();

$url = $_GET["cp"];
//echo "URL: $url<br />";
//echo (strpos($url, "?") > 0) ? "Yup" . "<br />" : "Nope" . "<br />";
if (strpos($url, "?") > 0) {
    echo "Current Page: [" . $url . "]<br>";
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
    if (performLogin($un, $pw, $conn)) {
        echo "<br>Successful login<br>";
        echo "Username: " . $_SESSION["username"] . "<br>";
    } else {
        echo "Login Failed<br>";
        echo "Params: " . $params . "<br>";
        echo "un : " . $un . "<br>";
        echo "pw : " . $pw . "<br>";
    }
}

if (isset($_SESSION['activity']) && (time() - $_SESSION['activity'] > 1800)) {
    session_unset();
    session_destroy();
    echo "killed session\n";
    exit;
} else {
    $_SESSION['activity'] = time();

    if (isset($_SESSION["username"])) {
        // build navigation
        echo "authorized";
    } else {
        $_SESSION["prevPage"] = $_GET["cp"];
        echo "<br><br>set current page to " . $_GET["cp"];
    }
}

function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}