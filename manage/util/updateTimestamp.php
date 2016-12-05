<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 9/23/2016
 * Time: 10:29 AM
 */

include "dbconnect.php";

$testHTML = "";
$console = strip_tags($_GET["console"]);
$usernumber = strip_tags($_GET["usernumber"]);
$username = strip_tags($_GET["username"]);
$sym = strip_tags($_GET["environment"]);
$function = strip_tags($_GET["f"]);
$today = date("Y/m/d");
$currentTime = date("H:i:s a");

if ($function == "start") {
    $sql = "INSERT INTO SimpleTransactions(console, usernumber, username, sym, visit_date, start_time) VALUES ($console, $usernumber, '$username', $sym, '$today', '$currentTime')";
    $result = $conn->query($sql);
    if ($result) echo $conn->insert_id;
    else {
        echo "Failed on Insertion<br /><br />";
        echo "Console: $console<br />";
        echo "Usernumber: $usernumber<br />";
        echo "Username: $username<br />";
        echo "Environment: $sym<br />";
    }
} else if ($function == "stop") {
    $transactionID = $_GET["tid"];
    $sql = "UPDATE SimpleTransactions SET endTime='$currentTime' WHERE tid=$transactionID AND endTime IS NULL";
    $result = $conn->query($sql);
    if (!$result) echo "Failed on Update";
    else {
        $sql = "SELECT * FROM SimpleTransactions WHERE tid=$transactionID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<table class='transactionRecord'>";
            echo "<tr><th>Transaction ID</th><th>Console</th><th>User Number</th><th>Start Time</th><th>End Time</th></tr>";
            echo "<tr><td>" . $row["tid"] . "</td>";
            echo "<td>" . $row["console"] . "</td>";
            echo "<td>" . $row["usernumber"] . "</td>";
            echo "<td>" . $row["startTime"] . "</td>";
            echo "<td>" . $row["endTime"] . "</td></tr></table>";
        }
    }
} else {
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head><title>SimpleTransaction Output</title>";
    echo "<style>table th, table td { padding: 7px 10px; text-align: center; }</style>";
    echo "</head><body>";
    $testHTML .= $sql . "<br />";
    $testHTML .= $conn->error . "<br />";

    $sql = "SELECT * FROM SimpleTransactions ORDER BY tid DESC LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $testHTML .= "<table border='1'>";
        $testHTML .= "<tr><th>Transaction ID</th><th>Console</th><th>User Number</th><th>Username</th><th>Sym</th><th>Visit Date</th><th>Start Time</th><th>End Time</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $testHTML .= "<tr>";
            $testHTML .= "<td>" . $row["tid"] . "</td>";
            $testHTML .= "<td>" . $row["console"] . "</td>";
            $testHTML .= "<td>" . $row["usernumber"] . "</td>";
            $testHTML .= "<td>" . $row["username"] . "</td>";
            $testHTML .= "<td>" . $row["sym"] . "</td>";
            $testHTML .= "<td>" . $row["visit_date"] . "</td>";
            $testHTML .= "<td>" . $row["start_time"] . "</td>";
            $testHTML .= "<td>" . $row["end_time"] . "</td>";
            $testHTML .= "</tr>";
        }
        $testHTML .= "</table>";
    }
    echo $testHTML;
    echo "<script type='text/javascript'>setInterval(function(){ location.reload(); }, 5000);</script>";
    echo "</body></html>";
}
