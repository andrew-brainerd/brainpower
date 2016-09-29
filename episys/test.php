<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 9/22/2016
 * Time: 3:53 PM
 */

//header('content-type: application/json; charset=utf-8');
//header("access-control-allow-origin: *");

$host_name = "db648629860.db.1and1.com";
$database = "db648629860";
$user_name = "dbo648629860";
$password = "Umcu@54!#";

$str1 = $_GET['a'];
$str2 = $_GET['b'];
$str3 = $_GET['c'];

$conn = new mysqli($host_name, $user_name, $password, $database);
if ($conn->connect_error) {
    $success = "Failed to connect to database: " . mysqli_connect_error();
    $result = false;
} else {
    $success = "Connected to database :D";
    if ($str1 != "" && $str2 != "" && $str3 != "")
        $sql = "INSERT INTO initial_test(str1, str2, str3) VALUES('$str1', '$str2', '$str3')";
    $result = $conn->query($sql);
}

echo "<h1 style='font-family: sans-serif'>$success</h1>";
if ($result) echo "<h2 style='font-family: sans-serif'>Wrote to table :D</h2>";
else echo "<h2 style='font-family: sans-serif'>$result</h2>";
