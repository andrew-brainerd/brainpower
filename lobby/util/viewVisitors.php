<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 3/1/2016
 * Time: 4:02 PM
 */

include "dbconnect.php";

$today = $_POST['searchDate'];
$branch = $_GET['branch'];
if ($branch === "" || $branch === null) $branch = $_POST['branch'];
if ($today == "") $today = date("Y/m/d");

$slt = "SELECT *";
$frm = " FROM SimpleVisitors";
$whr = " WHERE location='$branch' AND visit_date = '$today' ";
$ord = "ORDER BY time_out ASC, time_in DESC";
$sql = $slt . $frm . $whr . $ord;

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    for ($statusTable = 0; $statusTable < 3; $statusTable++) {
        $slt = "SELECT *";
        $frm = " FROM SimpleVisitors";
        $whr = " WHERE location='$branch' AND visit_date = '$today' AND status=$statusTable ";
        $ord = "ORDER BY time_out ASC, time_in DESC";
        $sql = $slt . $frm . $whr . $ord;
        switch ($statusTable) {
            case 0:
                $tableTitle = "Members Excitedly Waiting";
                break;
            case 1:
                $tableTitle = "Members Being aMAIZEd";
                break;
            case 2:
                $tableTitle = "Members Happily Serviced";
                break;
            default:
                $tableTitle = "something went wrong";
        }
        echo "<h2 class='tableTitle'>$tableTitle</h2>";

        $result = $conn->query($sql);
        echo "<div class='tableContainer' id='status$statusTable''>";
        if ($result->num_rows > 0) {
            echo "<div class='table' id='viewTable'>";
            buildTableHeader($statusTable);
            while ($row = $result->fetch_assoc()) {
                buildTableRow($statusTable, $row);
            }
            echo "</div>";  // table
        }
        echo "</div>"; // table container
        echo "<hr>";
    }
} else {
    echo "<h1>No Visitor Check-Ins Today</h1>";
}

$conn->close();

function buildTableHeader($table)
{
    echo "<div class='row viewHeader'>";
    echo "<div class='hcell'>Name</div>";
    if ($table == 0) {        // Status = Waiting
        echo "<div class='hcell time'>Time Waiting</div>";
    } else if ($table == 1) {   // Status = Being Helped
        echo "<div class='hcell time'>Time With MSR</div>";
    } else if ($table == 2) {   // Status = Done
        echo "<div class='hcell' time'>Visit Length</div>";
    }
    echo "<div class='hcell'>Reason</div>";
    echo "</div>";
}
function buildTableRow($table, $row)
{
    $currentTime = time();
    $reason = $row["reason"];
    if (strlen($reason) > 30) {
        $reason = substr($reason, 0, 16) . "...";
    }
    $timeIn = strtotime($row["time_in"]);
    $timeHelp = strtotime($row["time_help"]);
    $vid = $row["vid"]; // remove for live (probably)
    $status = $row['status'];
    if ($status == "2") $reason = $reason . " --> " . $row["note_text"];
    if ($table == 0) {
        $timeElapsed = gmdate("H:i:s", $currentTime - $timeIn);
        $hours = intval(substr($timeElapsed, 0, 2));
        $minutes = intval(substr($timeElapsed, 3, 5));
        echo "<div class='row' data-vid='$vid'>";
        echo "<div class='cell'>" . $row["fname"] . " " . $row["lname"] . "</div>";
        echo "<div class='cell time'>";
        if ($hours > 0) echo "$hours hr ";
        echo "$minutes min</div>";
        echo "<div class='cell reason'>" . $reason . "</div>";
    } else if ($table == 1) {
        $timeElapsed = gmdate("H:i:s", $currentTime - $timeHelp);
        $hours = intval(substr($timeElapsed, 0, 2));
        $minutes = ($hours * 60) + (intval(substr($timeElapsed, 3, 5)));
        echo "<div class='row' data-vid='$vid'>";
        echo "<div class='cell'>" . $row["fname"] . " " . $row["lname"] . "</div>";
        echo "<div class='cell time'>" . $minutes . " min</div>";
        echo "<div class='cell reason'>" . $reason . "</div>";
    } else if ($table == 2) {
        $timeOut = strtotime($row["time_out"]);
        $timeElapsed = gmdate("H:i:s", $timeOut - $timeIn);
        echo "<div class='row noHover' data-vid='-1'>";
        echo "<div class='cell'>" . $row["fname"] . " " . $row["lname"] . "</div>";
        echo "<div class='cell time'>" . $timeElapsed . "</div>";
        echo "<div class='cell'><input type='button' class='detailsButton' data-vid='$vid' value='Visit Details'/></div>";
    }
    echo "</div>";  // row
}