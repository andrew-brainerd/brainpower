<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/1/2016
 * Time: 6:37 PM
 */

$vid = $_POST["vid"];
$noteText = strip_tags($_POST["noteText"]);
if ($noteText === null) $noteText = "";
$teamID = $_POST["teamID"];
$status = $_POST["status"];
$timeOut = date("H:i:s a");

include "dbconnect.php";

$statusInfo = "";
if ($status == "1") $statusInfo = " team_id='$teamID',";
else if ($status == "2") $statusInfo = " time_out='$timeOut',";
$sql = "UPDATE SimpleVisitors SET$statusInfo status='$status', note_text='$noteText' WHERE vid='$vid'";

$success2 = $conn->query($sql);
if ($success2 == TRUE) {
    echo "Updated Time Out $sql";
} else echo "Failed to update $sql";

$conn->close();

