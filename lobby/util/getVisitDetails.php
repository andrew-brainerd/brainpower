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

$slt = "SELECT * ";
$frm = "FROM SimpleVisitorsTest sv LEFT JOIN TeamMembers tm on sv.team_id = tm.tid ";
$whr = "WHERE location='$branch' AND visit_date = '$today' AND vid=$vid ";
$sql = $slt . $frm . $whr;

$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $timeIn = strtotime($row["time_in"]);
    $timeHelp = strtotime($row["time_help"]);
    $timeOut = strtotime($row["time_out"]);
    echo "<h2>Visit Details for " . $row["fname"] . " " . $row["lname"] . "</h2>";
    echo "<br /><br />";
    echo "<div class='table'>";
    echo buildRow("Came For: ", $row["reason"]);
    echo buildRow("Left With: ", $row["note_text"]);
    echo buildRow("Helped By: ", $row["team_name"]);
    echo buildRow("Time Waiting: ", doTimeStuff($timeIn, $timeHelp));
    echo buildRow("Time with MSR: ", doTimeStuff($timeHelp, $timeOut));
    echo "</div>";
} else {
    echo "<h3>Multiple rows returned</h3>";
    echo "<h4>$sql</h4>";
}

function buildRow($label, $value)
{
    $row = "<div class='row'>";
    $row .= "<div class='cell label'>$label</div>";
    $row .= "<div class='cell value'>$value</div>";
    $row .= "</div>";
    return $row;
}

function doTimeStuff($time1, $time2)
{
    $elapsedTime = gmdate("H:i:s", $time2 - $time1);
    $hours = intval(substr($elapsedTime, 0, 2));
    $minutes = intval(substr($elapsedTime, 3, 5));
    return (($hours > 0) ? "$hours hr " : "") . "$minutes min";
}
function out($str)
{
    echo "<h3>$str</h3>";
}