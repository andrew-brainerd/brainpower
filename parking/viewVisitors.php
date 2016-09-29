<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/1/2016
 * Time: 4:02 PM
 */

include "dbconnect.php";

$today = $_POST['searchDate'];
$location = $_POST['branch'];


$temp = $_GET['branch'];
$lcation = $temp;
//echo $location . "<br><br>";

if ($today == "")
    $today = date("Y/m/d");
else {
    echo "ERROR";
    exit(1);
}

$slt = "SELECT *";
$frm = " FROM Parking AS p";
$ijn = " INNER JOIN Visitors AS v ON p.vid = v.vid";
$whr = " WHERE visit_date = '$today' ";
if ($location != "") $whr = " WHERE location='$location' AND visit_date = '$today' ";
$lmt = "";
$ord = "ORDER BY time_out ASC, time_in DESC";
$sql = $slt . $frm . $ijn . $whr . $lmt . $ord;
//echo $whr . "<br><br>";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<div class='table' id='viewTable'>";
    echo "<div class='row' id='viewHeader'>";
    echo "<div class='hcell'>Name</div>";
    echo "<div class='hcell'>Vehicle</div>";
    echo "<div class='hcell'>Spot</div>";
    echo "<div class='hcell'>Time In</div>";
    echo "<div class='hcell'>Time Out</div>";
    echo "<div class='hcell'>Reason</div>";
    echo "</div>";
    while ($row = $result->fetch_assoc()) {
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
        $reason = $row["reason"];
        if (strlen($reason) > 30) {
            $reason = substr($reason, 0, 16) . "...";
        }
        $timeIn = date("g:i a", strtotime($row["time_in"]));
        $timeOut = date("g:i a", strtotime($row["time_out"]));
        if ($timeOut === "12:00 am") {
            $timeOut = "-";
            $pid = $row["pid"];
        } else $pid = -1;

        echo "<div class='row' onclick='checkOut(" . $pid . ")'>";
        echo "<div class='cell'>" . $row["fname"] . " " . $row["lname"] . "</div>";
        echo "<div class='cell'>" . $row["make"] . " " . $row["model"] . "</div>";
        echo "<div class='cell time'>" . $spot . "</div>";
        echo "<div class='cell time'>" . $timeIn . "</div>";
        echo "<div class='cell time'>" . $timeOut . "</div>";
        echo "<div class='cell' reason>" . $reason . "</div>";
        echo "</div>";
    }
    echo "</div>";
    //echo "<div class='table' id='fixedHeader'></div>";
} else {
    echo "<h1>No Visitor Check-Ins Today</h1>";
}
$conn->close();