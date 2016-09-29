<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/30/2016
 * Time: 5:30 PM
 */

include "dbconnect.php";

$username = strip_tags($_POST["un"]);
$plainpw = $_POST["pw"];
$password = password_hash($_POST["pw"], PASSWORD_DEFAULT) . "\n";
$authlv = $_POST["al"];

$ins = "INSERT INTO Users(username, password, auth_level)";
$val = "VALUES('$username', '$password', '$authlv')";
$sql = $ins . " " . $val;
$success = $conn->query($sql);
if ($success === TRUE) {
    echo "Added new user :D";
} else {
    echo "Failed to add user :(";
}
$conn->close();