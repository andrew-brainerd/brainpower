<?php

$isTeamMember = strip_tags(isset($_GET["team"]));

if ($isTeamMember) {
    echo "<ul id='topNav'>";
    echo "<li class='noNav' id='navTitle'><span></span></li>";
    echo "<li id='checkIn'><span>Member Check-In</span></li>";
    echo "<li id='checkOut'><span>Member Activity</span></li>";
    echo "<li id='reporting'><span>Download Report</span></li>";
    echo "<li id='logOut'><span>Switch Branch</span></li>";
    echo "<li id='menuIcon'><span>☰</span></li>";
    echo "</ul>";
} else {
    echo "<img src='img/umcu_logo.png' alt='UMCU Logo'/>";

}