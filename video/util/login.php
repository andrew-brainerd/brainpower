<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/30/2016
 * Time: 6:27 PM
 */

include "dbconnect.php";
session_start();

$username = strip_tags($_POST["username"]);
$password = strip_tags($_POST["password"]);

if ($username . $password == "") {
    $username = strip_tags($_GET["username"]);
    $password = strip_tags($_GET["password"]);
}
echo "Username: " . $username . "<br />";
echo "Password: " . $password . "<br />";
if (performLogin($username, $password, $conn)) {
    echo "Login Sucessful<br />";
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
            $conn->close();
            return true;
        } else echo "<div id='loginError'>Incorrect Password</div>";
    } else echo "<div id='loginError'>Invalid Username</div>";
    $conn->close();
    return false;
}
