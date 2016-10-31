<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/17/2016
 * Time: 5:54 PM
 */

include "dbconnect.php";

$sql = "SELECT * FROM Branches";
$result = $conn->query($sql);

echo "<option value='-1'>- All Branches -</option>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reason = $row['name'];
        echo "<option value='" . $reason . "'>" . $reason . "</option>";
    }
    //echo "<option value='0'>Other</option>";
}