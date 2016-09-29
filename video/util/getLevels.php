<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/18/2016
 * Time: 3:41 PM
 */

include "dbconnect.php";

$sql = "SELECT * FROM Levels";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<option value='0' selected>-- Select Authorization Level --</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["val"] . "'>" . $row["description"] . "</option>";
    }
}