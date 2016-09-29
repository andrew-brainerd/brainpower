<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/21/2016
 * Time: 1:56 PM
 */

include "../parking/dbconnect.php";

$sql = "SELECT visit_date FROM Parking where visit_date='" . date("Y/m/d") . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $count = $result->num_rows;
    $msg = "The tally is in! " . $count . " visitors checked in today :D\n";
    //$msg .= $backup_file_name;
    $emailTo = "9897210902@vtext.com";
    $emailFrom = "walter@umculobby.com";
    $headers = "From: UMCU Lobby <" . $emailFrom . ">\r\n";
    //mail($emailTo, "", $msg, $headers);
} else {
    echo "Something went wrong\n";
    echo "SQL: " . $sql . "\n";
}
$conn->close();