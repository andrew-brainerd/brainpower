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
    for ($i = 0; $i < 3; $i++) {
        $slt = "SELECT *";
        $frm = " FROM SimpleVisitors";
        $whr = " WHERE location='$branch' AND visit_date = '$today' AND status=$i ";
        $ord = "ORDER BY time_out ASC, time_in DESC";
        $sql = $slt . $frm . $whr . $ord;
        switch ($i) {
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

        if ($result->num_rows > 0) {
            echo "<div class='table' id='viewTable'>";
            echo "<div class='row' id='viewHeader'>";
            echo "<div class='hcell'>Name</div>";
            echo "<div class='hcell'>Time In</div>";
            echo "<div class='hcell'>Time Out</div>";
            echo "<div class='hcell'>Reason</div>";
            //echo "<div class='hcell'>Status</div>";
            echo "</div>";
            while ($row = $result->fetch_assoc()) {
                $reason = $row["reason"];
                if (strlen($reason) > 30) {
                    $reason = substr($reason, 0, 16) . "...";
                }
                $timeOut = date("g:i a", strtotime($row["time_out"]));
                $timeIn = date("g:i a", strtotime($row["time_in"]));
                if ($timeOut === "12:00 am") {
                    $timeOut = "-";
                    $vid = $row["vid"];
                } else $vid = -1;

                $status = $row['status'];
                if ($status == "2") $reason = $reason . " --> " . $row["noteText"];
                if ($status == "0") {
                    echo "<div class='row'>"; // onclick='helpMember($vid)'
                    $status = "Waiting";
                } else if ($status == "1") {
                    echo "<div class='row'>";  // onclick='finalNote($vid, $(this))'
                    $status = "With MSR";
                } else {
                    echo "<div class='row'>";
                    $status = "Done";
                }
                echo "<div class='cell'>" . $row["fname"] . " " . $row["lname"] . "</div>";
                //echo "<div class='cell location'>" . $row["location"] . "</div>";
                echo "<div class='cell time'>" . $timeIn . "</div>";
                echo "<div class='cell time'>" . $timeOut . "</div>";
                echo "<div class='cell reason'>" . $reason . "</div>";
                //echo "<div class='cell'>$status</div>";
                echo "</div>";
            }
            echo "</div>";
        }
    }
} else {
    echo "<h1>No Visitor Check-Ins Today</h1>";
}

$conn->close();