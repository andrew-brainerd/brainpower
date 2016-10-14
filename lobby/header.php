<!--<div id="timer"></div>-->
<!---->
<?php

if ($_GET["team"] == "true") {
    echo "<ul id='topNav'>";
    echo "<li id='navTitle'><span>UMCU Lobby Management</span></li>";
    echo "<li id='checkIn'><span>Check-In</span></li>";
    echo "<li id='checkOut'><span>Member Activity</span></li>";
    echo "<li id='reporting'><span>Reports</span></li>";
    echo "<li id='menuIcon'><span>☰</span></li>";
    echo "</ul>";
} else {
    echo "<img src='img/umcu_logo.png' alt='UMCU Logo'/>";
}