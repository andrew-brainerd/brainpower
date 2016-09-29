<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/24/2016
 * Time: 9:48 AM
 */
/*** DEV SERVER ***/ /*then*/
/*** LIVE SERVER ***/
//echo "<div style='padding: 100px; background: green;'>Host: " . $_SERVER["HTTP_HOST"] . "</div>";

$server = "live";
if ($server == "dev") {
    $host_name = "db614514643.db.1and1.com";
    $database = "db614514643";
    $user_name = "dbo614514643";
    $password = "Zx81000935";
} else {
    $host_name = "db618070060.db.1and1.com";
    $database = "db618070060";
    $user_name = "dbo618070060";
    $password = "Umcu@54!#";
}

$conn = new mysqli($host_name, $user_name, $password, $database);
if ($conn->connect_error) {
    $success = "Failed to connect to database: " . mysqli_connect_error();
} else {
    $success = "Connected to database :D";
}
//echo "<h1 style='font-family: sans-serif'>" . $success1 . "</h1>";
//echo "<h1 style='font-family: sans-serif'>" . $success2 . "</h1>";


//if (strpos($_SERVER["HTTP_HOST"], "notmuch") >= 0) {