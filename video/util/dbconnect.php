<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/30/2016
 * Time: 6:23 PM
 */

/*** DEV SERVER ***/ /*
if (strpos($_SERVER["HTTP_HOST"], "notmuch") >= 0) {
    $host_name  = "db619987035.db.1and1.com";
    $database   = "db619987035";
    $user_name  = "dbo619987035";
    $password   = "Umcu@54!#";
}
else {
    /*** LIVE SERVER ***/
$host_name = "db622747619.db.1and1.com";
$database = "db622747619";
$user_name = "dbo622747619";
$password = "Umcu@54!#";
//}
$conn = new mysqli($host_name, $user_name, $password, $database);
if ($conn->connect_error) {
    $success = "Failed to connect to database: " . mysqli_connect_error();
} else {
    $success = "Connected to database :D";
}