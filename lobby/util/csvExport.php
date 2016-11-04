<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 10/28/2016
 * Time: 5:36 PM
 */
//header("Content-Type: text/json; charset=utf-8");

$startDate = $_GET["start"];
$endDate = $_GET["end"];
$branch = $_GET["branch"];

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=UMCU_Lobby_DataDump.csv");

$output = fopen("php://output", "w");

fputcsv($output, array("First Name", "Last Name", "Reason for Visit", "Time In", "Time Helped", "Time Out", "Visit Date", "Location", "Team Member ID", "Checkout Note"));

include "dbconnect.php";

$sql = "SELECT fname, lname, reason, time_in, time_help, time_out, visit_date, location, team_id, note_text ";
$sql .= "FROM SimpleVisitors ";
$sql .= "WHERE visit_date>='$startDate' AND visit_date<='$endDate' ";
if ($branch != "" && $branch != null && $branch != "-1") $sql .= " AND location='$branch' ";
$sql .= "ORDER BY visit_date ASC, time_in ASC";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //echo "<br />" . $row["lname"];
        fputcsv($output, $row);
    }
}