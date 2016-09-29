<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

include "../dbconnect.php";

$today = $_GET["searchDate"];

//$today = new DateTime("")
if ($today == "")
    $today = date("Y/m/d");
else {
    echo "ERROR: [" . $today . "]";
    exit(1);
}

$slt = "SELECT *";
$frm = " FROM Parking AS p";
$ijn = " INNER JOIN Visitors AS v ON p.vid = v.vid";
$whr = " WHERE visit_date = '$today'";
$lmt = "";
$ord = "ORDER BY time_out ASC, time_in DESC";
$sql = $slt . $frm . $ijn . $whr . $lmt . $ord;

$visitors = array();

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $vid = $row["vid"];
        $fname = $row["fname"];
        $lname = $row["lname"];
        $reason = $row["reason"];
        $spot = $row["spot_num"];
        $timeIn = date("g:i a", strtotime($row["time_in"]));
        $timeOut = date("g:i a", strtotime($row["time_out"]));
        if ($timeOut == "12:00 am") $timeOut = "-";

        $visitors["VisitorID" . $count] = strval($vid);
        $visitors["First" . $count] = $fname;
        $visitors["Last" . $count] = $lname;
        $visitors["Reason" . $count] = $reason;
        $visitors["Spot" . $count] = $spot;
        $visitors["TimeIn" . $count] = $timeIn;
        $visitors["TimeOut" . $count] = $timeOut;
        $count++;
    }
    $visitors["Count"] = strval($count);
    echo json_encode($visitors, JSON_PRETTY_PRINT);
} else {
    $visitors["VisitorID0"] = "000";
    $visitors["First0"] = "No Visitors Today";
    $visitors["Last0"] = "";
    $visitors["Reason0"] = "";
    $visitors["Spot0"] = "";
    $visitors["TimeIn0"] = "";
    $visitors["TimeOut0"] = "";
    $visitors["Count"] = "1";
    echo json_encode($visitors, JSON_PRETTY_PRINT);
}

//print_r($visitors);

$conn->close();