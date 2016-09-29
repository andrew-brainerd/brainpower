<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/24/2016
 * Time: 10:21 AM
 */

$first = strip_tags($_POST["fname"]);
$last = strip_tags($_POST["lname"]);

include "dbconnect.php";

$slt = "SELECT vid, fname, lname, make, model, last_visit";
$frm = " FROM Visitors";
$whr = " WHERE fname like '$first%' AND lname like '$last%'";
$ord = " ORDER BY last_visit DESC";
$lmt = " LIMIT 5";
$sql = $slt . $frm . $whr . $ord . $lmt;

if (strlen($first) > 0 || strlen($last) > 0) {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 0;
        echo "<div class='table' id='results'>";
        echo "<div class='row'>";
        echo "<div class='hcell'>Last</div>";
        echo "<div class='hcell'>First</div>";
        echo "<div class='hcell'>Vehicle Information</div>";
        echo "</div>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='row' onclick='fetchVisitorInfo(" . $row["vid"] . ")'>";
            echo "<div class='cell'>" . $row["lname"] . "</div>";
            echo "<div class='cell'>" . $row["fname"] . "</div>";
            echo "<div class='cell'>" . $row["make"] . " " . $row["model"] . "</div>";
            echo "</div>";
            $i = $i + 1;
        }
        echo "</div>";
    }
    echo "<div id='new' onclick='showMoreInfo(" . ")'>Continue as New Visitor</div>";
}
echo "</div>";
$conn->close();