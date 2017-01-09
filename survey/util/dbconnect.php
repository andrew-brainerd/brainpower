<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 1/9/2017
 * Time: 12:51 PM
 */

$host_name = "localhost";
$database = "umcu_survey";
$user_name = "root";
$password = "d@t@b@sep@ssw0rd";

$conn = new mysqli($host_name, $user_name, $password, $database);
if ($conn->connect_error) {
    $success = "Failed to connect to database: " . mysqli_connect_error();
} else {
    $success = "Connected to database :D";
}