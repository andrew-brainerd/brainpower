<!--<div id="timer"></div>-->
<!---->
<?php

$isTeamMember = (bool)$_GET["team"] == "true";
$isManager = $_GET["role"] == "manager";
$currentBranch = $_GET["branch"];
$isiPad = (bool)strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');

if ($isTeamMember) {
    echo "<ul id='topNav'>";
    echo "<li class='noNav' id='navTitle'><span>UMCU Lobby - $currentBranch</span></li>";
    echo "<li id='checkIn'><span>Member Check-In</span></li>";
    echo "<li id='checkOut'><span>Member Activity</span></li>";
    echo "<li id='reporting'><span>Download Report</span></li>";
    echo "<li id='logOut'><span>Log Out</span></li>";
    //echo "<li class='noNav' id='currentUser'><span>$currentBranch Branch</span></li>";
    echo "<li id='menuIcon'><span>☰</span></li>";
    echo "</ul>";
} else {
    echo "<img src='img/umcu_logo.png' alt='UMCU Logo'/>";

}