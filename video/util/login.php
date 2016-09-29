<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/30/2016
 * Time: 6:27 PM
 */

include "dbconnect.php";
session_start();

$username = strip_tags($_POST["un"]);
$password = $_POST["pw"];
$u = trim($_GET["username"]);
$p = trim($_GET["password"]);

if ($username . $password != "") {
    performLogin($username, $password, $conn);
}
if ($u . $p != "") {
    performLogin($u, $p, $conn);
}

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
                $_SESSION["prevPage"] = "http://umculobby.com/video";
                echo "@" . $_SESSION["prevPage"];
                $_SESSION["prevPage"] = "";
            }
            $conn->close();
            return true;
        } else echo "!Incorrect Password";
    } else echo "!Invalid username";
    $conn->close();
    return false;
}
