<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/20/2016
 * Time: 11:40 AM
 */

session_start();

include "dbconnect.php";
include "globals.php";

$vid = strip_tags($_GET["vid"]);

// Update or create Reason record
$sql = "SELECT * FROM Videos WHERE vid='$vid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newCount = $row["play_count"] + 1;
    $sql = "UPDATE Videos SET play_count='$newCount' WHERE vid='$vid'";
    echo "Updated count to " . $newCount . "<br><br>";
    sendUpdateEmail(strtoupper($_SESSION["username"]) . " watched " . $row["title"], "Video Update");
} else {
    echo "error: no rows returned";
}
$conn->query($sql);


$sql = "INSERT INTO Reasons(reason, used_count) VALUES ('$reason', 1)";
$day = date("Y/m/d");
$time = date("H:i:s a");
$sql = "INSERT INTO Views(vid, view_date, view_time) VALUES ('$vid', '$day', '$time')";
$conn->query($sql);

$conn->close();