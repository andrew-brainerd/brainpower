<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 5/2/2016
 * Time: 6:00 PM
 */

include "../video/util/dbconnect.php";
include "../video/util/globals.php";

$today = date("Y/m/d");
$slt = "SELECT title, play_count, view_time ";
$frm = "FROM Videos AS vd INNER JOIN Views AS vw ON vd.vid = vw.vid ";
$whr = "WHERE view_date = '$today'";
$sql = $slt . $frm . $whr;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $msg = "A whopping " . $result->num_rows . " videos were viewed today :D";
    if (sendEmail("9897210902@vtext.com", "walter@umculobby.com", "", $msg)) {
        echo "Sent Email: <br><hr>" . $msg . "<br><hr>";
    } else echo "Failed to send email";
    $msg = "<html><head><style type='text/css'>";
    $msg .= "</style></head><body>";
    $msg .= "<table><tr><th>Title</th><th>Plays</th></tr>";
    $msg .= "</body></html>";
    echo $msg;
} else {
    echo "Something went wrong\n";
    echo "SQL: " . $sql . "\n";
}
$conn->close();