<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/1/2016
 * Time: 6:37 PM
 */

$vid = $_POST["vid"];
$noteText = strip_tags($_POST["noteText"]);
$status = $_POST["status"];
$timeOut = date("H:i:s a");

include "dbconnect.php";

$done = "";
if ($status == "2") $done = " time_out='$timeOut',";
$sql = "UPDATE SimpleVisitors SET$done status='$status', noteText='$noteText' WHERE vid='$vid'";

$success2 = $conn->query($sql);
if ($success2 === TRUE) {
    echo "Updated Time Out";
} else echo "Failed to update";

$conn->close();

