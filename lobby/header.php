<!--<div id="timer"></div>-->
<!---->
<?php

$isTeamMember = $_GET["team"] == "true";
$isManager = $_GET["role"] == "manager";
$currentBranch = $_GET["branch"];

if ($isTeamMember) {
    echo "<ul id='topNav'>";
    echo "<li class='noNav' id='navTitle'><span>UMCU Lobby - $currentBranch</span></li>";
    if ($isManager) echo "<li id='reporting'><span>Reports</span></li>";
    echo "<li id='checkIn'><span>Member Check-In</span></li>";
    echo "<li id='checkOut'><span>Member Activity</span></li>";
    echo "<li id='logOut'><span>Log Out</span></li>";
    //echo "<li class='noNav' id='currentUser'><span>$currentBranch Branch</span></li>";
    echo "<li id='menuIcon'><span>☰</span></li>";
    echo "</ul>";
} else {
    echo "<img src='img/umcu_logo.png' alt='UMCU Logo'/>";

}