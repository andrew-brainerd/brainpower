<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 5/11/2016
 * Time: 6:05 PM
 */


include "../video/util/dbconnect.php";
include "../video/util/globals.php";

$today = date("Y/m/d");
$slt = "SELECT COUNT(vd.vid) as daily_plays, title, play_count, view_time, view_date ";
$frm = "FROM Videos AS vd INNER JOIN Views AS vw ON vd.vid = vw.vid ";
$whr = "WHERE view_date = '$today' ";
$gby = "GROUP BY title ";
$oby = "ORDER BY daily_plays DESC";
$sql = $slt . $frm . $whr . $gby . $oby;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    //echo "<h2>A whopping " . $result->num_rows . " videos were viewed today :D</h2>";
    $msg = "<html><head><style type='text/css'>";
    $msg .= "table { border-collapse: collapse; }";
    $msg .= "th { padding: 5px 15px; }";
    $msg .= "td { border: 1px solid black; padding: 7px 15px; text-align: center; }";
    $msg .= "</style></head><body>";
    $msg .= "<table><tr><th>Title</th><th>Plays Today</th><th>Total Plays</th></tr>";
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $msg .= "<tr>";
        $title = $row["title"];
        //if (strlen($title) > 20) $title = substr($title, 0, 20);
        $msg .= "<td>" . $title . "</td>";
        $msg .= "<td>" . $row["daily_plays"] . "</td>";
        $msg .= "<td>" . $row["play_count"] . "</td>";
        $msg .= "</tr>";
        $count = $count + (int)$row["daily_plays"];
    }
    $msg .= "</table><h3>Total Plays Today: " . $count . "</h3></body></html>";
    echo $msg;
    //sendEmail("abrainerd@umcu.org, drwb333@gmail.com", "walter@umculobby.com", "Today's Views", $msg, "html");
    //sendEmail("", "walter@umculobby.com", "Today's Views", $msg, "html");
} else {
    echo "Something went wrong\n";
    echo "SQL: " . $sql . "\n";
}
$conn->close();