<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/22/2016
 * Time: 6:24 PM
 */

include 'dbconnect.php';

$vid = $_POST["vid"];

$sql = "SELECT umcu_username, assigned_spot FROM Visitors WHERE vid='$vid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_un = $row['umcu_username'];
    $_ps = $row['assigned_spot'];
    if ($_un === NULL && $_ps === NULL) {
        //echo "0";
        echo '<input type="text" id="tmEmail" name="tmEmail" placeholder="UMCU Username" autocomplete="off"/>';
        echo '<span>@umcu.org</span>'; // id="tmSpan"
        echo '<input type="number" id="tmAssSpot" name="tmAssSpot" placeholder="My Spot"/>';
        echo '<input type="text" id="vehicleDesc" name="vehicleDesc" placeholder="Vehicle Description" autocomplete="off"/>';
    } else {
        //echo "1";
        echo '<input type="text" id="vehicleDesc" name="vehicleDesc" placeholder="Vehicle Description" autocomplete="off"/>';
    }
    //echo " - " . $vid . " | " . $_un . " | " . $_ps;
} else {
    echo "Database call returned no rows";
}

$conn->close();