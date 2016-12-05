<?php
include "dbconnect.php";

$fname = strip_tags($_POST["fname"]);
$lname = strip_tags($_POST["lname"]);
$reason = strip_tags($_POST["reason"]);
$branch = strip_tags($_POST["branch"]);
$today = date("Y/m/d");
$timeIn = date("H:i:s a");

$sql = "INSERT INTO SimpleVisitors (fname, lname, reason, time_in, visit_date, location) 
        VALUES ('$fname', '$lname', '$reason', '$timeIn', '$today', '$branch')";
$success = $conn->query($sql);
if ($success) echo "<h2>Wrote to database</h2>";
else echo "<h2>" . $conn->error . "</h2>";
$conn->close();