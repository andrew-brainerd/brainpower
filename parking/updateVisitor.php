<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/26/2016
 * Time: 11:02 AM
 */

$vid = $_POST["vid"];
$fname = $_POST["fn"];
$lname = $_POST["ln"];
$make = $_POST["mk"];
$model = $_POST["md"];

include "dbconnect.php";

$sql = "UPDATE Visitors SET fname='$fname' WHERE vid='$vid' and fname<>'$fname'";
$success2 = $conn->query($sql);
if ($success2 === TRUE) {
    echo "Updated First Name\n";
} else echo "error on fname update";

$sql = "UPDATE Visitors SET lname='$lname' WHERE vid='$vid' and lname<>'$lname'";
$success2 = $conn->query($sql);
if ($success2 === TRUE) {
    echo "Updated Last Name\n";
} else echo "error on lname update";

$sql = "UPDATE Visitors SET make='$make' WHERE vid='$vid' and make<>'$make'";
$success2 = $conn->query($sql);
if ($success2 === TRUE) {
    echo "Updated Make\n";
} else echo "error on make update";

$sql = "UPDATE Visitors SET model='$model' WHERE vid='$vid' and model<>'$model'";
$success2 = $conn->query($sql);
if ($success2 === TRUE) {
    echo "Updated Model to " . $model . "\n";
} else echo "error on model update";

$conn->close();