<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "head.php";
    $isTeamMember = isset($_GET["team"]);
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/lobby.css"/>
    <link rel="stylesheet" href="/css/control.css"/>
    <title></title>
</head>
<body>
<header>
    <?php include "header.php" ?>
</header>
<div id="initialForm">
    <form autocomplete="off" spellcheck="false">
        <div id="nameInfo">
            <div>
                <label for="fname" title="First Name" data-alt="First"></label>
                <input type="text" id="fname"/>
            </div>
            <div>
                <label for="lname" title="Last Name" data-alt="Last"></label>
                <input type="text" id="lname"/>
            </div>
            <div class="span2">
                <select id="reason" name="reason" title="Reason for Visit"></select>
            </div>
            <div>
                <label for="addInfo"></label>
                <input type="text" id="addInfo"/>
            </div>
            <div class="span2">
                <div class="toggle-label">Have an Appointment?</div>
                <div class="switch" id="appointmentSwitch">
                    <input type="checkbox" class="toggle toggle-round" id="toggle1" tabindex="-1">
                    <label for="toggle1" data-on="Yes" data-off="No"></label>
                </div>
            </div>
            <div class="span2" id="meetingInfo">
                <label for="meetingWith" title="Meeting With" data-alt="With"></label>
                <input type="text" id="meetingWith">
            </div>
            <div id="submitForm">Check-In</div>
        </div>
    </form>
</div>
<div id="thankYou">
    <h1>Thanks for Checking In</h1>
    <h1>Enjoy your time at UMCU!</h1>
</div>
<div id="viewVisitors"></div>
<form id="downloadReport" method="GET" action="/manage/util/csvExport.php">
    <label for="reportStartDate">Start Date</label>
    <input type="date" id="reportStartDate" name="start" value="<?php echo date('Y-m-d'); ?>"/>
    <label for="reportEndDate">End Date</label>
    <input type="date" id="reportEndDate" name="end" value="<?php echo date('Y-m-d'); ?>"/>
    <select id="branchList" name="branch" title="Branch List"></select>
    <input type="button" id="download" value="Download"/>
</form>
<div id="screensaver"></div>
<input type="text" id="decoy" title="" tabindex="-1 readonly"/>
<input type="hidden" id="team" value="<?php echo $isTeamMember ?>"/>
<script src="/js/secure.js"></script>
<?php include "util/jquery.php"; echo "\n"; ?>
<script src="js/lobby.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>