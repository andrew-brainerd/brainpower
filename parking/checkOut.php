<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/1/2016
 * Time: 6:37 PM
 */

$pid = $_POST["pid"];
$timeOut = date("H:i:s a");

include "dbconnect.php";

/*$sql = "SELECT time_out FROM Parking WHERE pid='$pid' and time_out > 0";
$result = $conn->query($sql);
if ($result->num_rows != 0) {
    echo "Visitor already checked out";
    exit;
}
else echo $result->fetch_assoc()["time_out"];*/
$sql = "UPDATE Parking SET time_out='$timeOut' WHERE pid='$pid'";
$success2 = $conn->query($sql);
if ($success2 === TRUE) {
    echo "Updated Time Out";
} else echo "Failed to update";

$conn->close();

