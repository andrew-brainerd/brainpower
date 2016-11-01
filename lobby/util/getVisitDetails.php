<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 10/27/2016
 * Time: 6:52 PM
 */

include "dbconnect.php";

$today = $_POST['searchDate'];
$vid = $_POST["vid"];
$branch = $_GET['branch'];
if ($branch === "" || $branch === null) $branch = $_POST['branch'];
if ($today == "") $today = date("Y/m/d");

$slt = "SELECT *";
$frm = " FROM SimpleVisitorsTest";
$whr = " WHERE location='$branch' AND visit_date = '$today' AND vid=$vid ";
$ord = "ORDER BY time_out ASC, time_in DESC";
$sql = $slt . $frm . $whr . $ord;

$result = $conn->query($sql);
if ($result->num_rows == 1) {
    echo "<h3>Found Visit Info :D</h3>";
    $row = $result->fetch_assoc();
    out($row["fname"] . " " . $row["lname"]);
} else {
    echo "<h3>Multiple rows returned</h3>";
    echo "<h4>$sql</h4>";
}

function out($str)
{
    echo "<h3>$str</h3>";
}