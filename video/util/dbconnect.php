<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/30/2016
 * Time: 6:23 PM
 */

$host_name = "localhost";
$database = "umcu_video";
$user_name = "root";
$password = "d@t@b@sep@ssw0rd";

if ($_SERVER['SERVER_ADDR'] != "10.0.0.79") {
    $host_name = "db622747619.db.1and1.com";
    $database = "db622747619";
    $user_name = "dbo622747619";
    $password = "Umcu@54!#";
}

$conn = new mysqli($host_name, $user_name, $password, $database);
if ($conn->connect_error) {
    $success = "Failed to connect to database: " . mysqli_connect_error();
} else {
    $success = "Connected to database[" . $_SERVER['SERVER_ADDR'] . "=>$host_name] :D";
}
//echo "<h1 style='font-family: sans-serif'>" . $success . "</h1>";