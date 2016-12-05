<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/1/2016
 * Time: 6:37 PM
 */

$vid = $_POST["vid"];
$updateInfo = strip_tags($_POST["updateInfo"]);
if ($noteText === null) $noteText = "";
$teamID = strip_tags($_POST["teamID"]);
$status = strip_tags($_POST["status"]);
$currentTime = date("H:i:s a");

include "dbconnect.php";

$statusInfo = "";
if ($status == "1") $statusInfo = " team_id='$updateInfo', time_help='$currentTime', ";
else if ($status == "2") $statusInfo = " time_out='$currentTime', note_text='$updateInfo', ";
else $statusInfo = " team_id='0', time_out=0, note_text='',";
$sql = "UPDATE SimpleVisitors SET$statusInfo status='$status' WHERE vid='$vid'";

$success2 = $conn->query($sql);
echo $sql;
/*if ($success2 == TRUE) {
    echo "Updated Time Out $sql";
} else echo "Failed to update $sql";*/

$conn->close();

