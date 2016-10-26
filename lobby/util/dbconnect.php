<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/24/2016
 * Time: 9:48 AM
 */

/*$host_name = "db624775871.db.1and1.com";
$database = "db624775871";
$user_name = "dbo624775871";
$password = "Umcu@54!#";*/

$host_name = "localhost";
$database = "umcu_lobby";
$user_name = "root";
$password = "d@t@b@asep@ssw0rd";

$conn = new mysqli($host_name, $user_name, $password, $database);
if ($conn->connect_error) {
    $success = "Failed to connect to database: " . mysqli_connect_error();
} else {
    $success = "Connected to database :D";
}
//echo "<h1 style='font-family: sans-serif'>" . $success . "</h1>";