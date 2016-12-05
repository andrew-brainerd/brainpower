<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

include "dbconnect.php";

$today = $_GET["searchDate"];

//$today = new DateTime("")
if ($today == "")
    $today = date("Y/m/d");
else {
    echo "ERROR: [" . $today . "]";
    exit(1);
}

$slt = "SELECT *";
$frm = " FROM SimpleVisitors";
$whr = " WHERE visit_date = '$today'";
$lmt = "";
$ord = "ORDER BY time_out ASC, time_in DESC";
$sql = $slt . $frm . $whr . $lmt . $ord;
//echo "<h2>" . $sql . "</h2>";

/*$json = json_encode(array(
     "client" => array(
        "build" => "1.0",
        "name" => "xxxxxx",
        "version" => "1.0"
     ),
     "protocolVersion" => 4,
     "data" => array(
        "distributorId" => "xxxx",
        "distributorPin" => "xxxx",
        "locale" => "en-US"
     )
));*/

$visitors = array();

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    //$vals = array();
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $vid = $row["vid"];
        $fname = $row["fname"];
        $lname = $row["lname"];
        $reason = $row["reason"];
        $timeIn = date("g:i a", strtotime($row["time_in"]));
        //$timeOut = $timeOut === "12:00 am" ? date("g:i a", strtotime($row["time_out"])) : "-";
        $timeOut = date("g:i a", strtotime($row["time_out"]));
        if ($timeOut == "12:00 am") $timeOut = "-";

        //array("build" => "1.0", "name" => "xxxxxx", "version" => "1.0")
        /*array_push($visitors, array(
            "Visitor" => array(
            "ID" => $vid, 
            "Reason" => $reason,
            "TimeIn" => $timeIn,
            "TimeOut" => $timeOut
            )
        ));*/
        $visitors["VisitorID" . $count] = strval($vid);
        $visitors["First" . $count] = $fname;
        $visitors["Last" . $count] = $lname;
        $visitors["Reason" . $count] = $reason;
        $visitors["TimeIn" . $count] = $timeIn;
        $visitors["TimeOut" . $count] = $timeOut;
        $count++;
    }
    $visitors["Count"] = strval($count);
    echo json_encode($visitors, JSON_PRETTY_PRINT);
} else {
    echo "<h1>No Visitor Check-Ins Today</h1>";
}
//print_r($visitors);

$conn->close();