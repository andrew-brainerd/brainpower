<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/25/2016
 * Time: 10:23 AM
 */

$userNum = $_POST["vid"];

include "dbconnect.php";

$slt = "SELECT *";
$frm = " FROM Visitors";
$whr = " WHERE vid = '$userNum'";
$lmt = "";
$sql = $slt . $frm . $whr . $lmt;

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo $row["lname"] . ",";
        echo $row["fname"] . ",";
        echo $row["make"] . ",";
        echo $row["model"] . ",";
        echo $row["last_visit"] . ",";
        echo "</div>";
    }
} else {
    echo "Nobody";
}
$conn->close();