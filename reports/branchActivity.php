<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 7/1/2016
 * Time: 4:19 PM
 */

$searchDate = $_GET['searchDate'];
//echo "<h2>Search Date: $searchDate</h2>";
$today = $searchDate == "" ? date("Y/m/d") : $searchDate;
$formattedToday = date("M d, Y", strtotime($today));
//echo "<h2>Today is $formattedToday</h2>";

include "../lobby/util/dbconnect.php";
$lobbyConn = $conn;
include "../parking/dbconnect.php";
$parkingConn = $conn;

//echo "Lobby: " . $lobbyConn->host_info . "<br>";
//echo "Parking: " . $parkingConn->host_info . "<br>";;

$selectedBranch = $_GET["branch"];
$hasParking = $selectedBranch == "Huron" || $selectedBranch == "William";

$frm = " Parking AS p";
$ijn = " INNER JOIN Visitors AS v ON p.vid = v.vid ";
$parkingFrom = $frm . $ijn;

$slt = "SELECT * ";
$frm = "FROM " . ($hasParking ? $parkingFrom : "SimpleVisitors ");
$whr = "WHERE location='$selectedBranch' AND visit_date='$today' ";
$ord = "ORDER BY time_out ASC, time_in DESC";
$sql = $slt . $frm . $whr . $ord;
//echo "<h5 style='color: purple;'>$sql</h5>";
$result = $hasParking ? $parkingConn->query($sql) : $lobbyConn->query($sql);

$lobbyConn->close();
$parkingConn->close();

if ($result->num_rows > 0) {
    echo "<div class='table' id='viewTable'>";
    echo "<div class='row' id='viewHeader'>";
    echo "<div class='hcell'>Name</div>";
    if ($hasParking) echo "<div class='hcell'>Vehicle</div>";
    if ($hasParking) echo "<div class='hcell'>Spot</div>";
    echo "<div class='hcell'>Time In</div>";
    echo "<div class='hcell'>Time Out</div>";
    echo "<div class='hcell'>Reason</div>";
    echo "</div>";
    while ($row = $result->fetch_assoc()) {
        $spot = "";
        if ($hasParking) {
            switch ($row["spot_num"]) {
                case 90:
                    $spot = "LD";
                    break;
                case 97:
                    $spot = "H1";
                    break;
                case 98:
                    $spot = "H2";
                    break;
                case 99:
                    $spot = "NM";
                    break;
                default:
                    $spot = $row["spot_num"];
            }
        }
        if (strlen($reason) > 30) {
            $reason = substr($reason, 0, 16) . "...";
        }
        $timeIn = date("g:i a", strtotime($row["time_in"]));
        $timeOut = date("g:i a", strtotime($row["time_out"]));
        if ($timeOut === "12:00 am") {
            $timeOut = "-";
            $pid = $row["pid"];
        } else $pid = -1;
        $reason = $row["reason"];

        echo "<div class='row'>";
        echo "<div class='cell'>" . $row["fname"] . " " . $row["lname"] . "</div>";
        if ($hasParking) echo "<div class='cell'>" . $row["make"] . " " . $row["model"] . "</div>";
        if ($hasParking) echo "<div class='cell time'>" . $spot . "</div>";
        echo "<div class='cell time'>" . $timeIn . "</div>";
        echo "<div class='cell time'>" . $timeOut . "</div>";
        echo "<div class='cell' reason>" . $reason . "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<h1 style='text-indent: 20px;'>No Visitor Check-Ins Today</h1>";
}