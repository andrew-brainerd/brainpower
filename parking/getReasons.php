<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/17/2016
 * Time: 5:54 PM
 */

include 'dbconnect.php';

//$sql = "SELECT reason FROM Reasons WHERE required=0";

$sql = "SELECT reason FROM Reasons WHERE required=1 ORDER BY used_count DESC";
$result = $conn->query($sql);

echo "<option value='-1'>-- Select A Reason --</option>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reason = $row['reason'];
        echo "<option value='" . $reason . "'>" . $reason . "</option>";
    }
    echo "<option value='0'>Other</option>";
}

$conn->close();