<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/26/2016
 * Time: 11:02 AM
 */

include "dbconnect.php";

$vid = strip_tags($_POST["vid"]);
$fname = strip_tags($_POST["fn"]);
$lname = strip_tags($_POST["ln"]);
$make = strip_tags($_POST["mk"]);
$model = strip_tags($_POST["md"]);

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