<?php
/*
$clientIP = $_SERVER['REMOTE_ADDR'];
if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94") header("Location: ../video");
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "head.php";
    $_GET["branch"] = strip_tags($_GET["branch"]);
    $branch = $_GET["branch"];
    $team = strip_tags($_GET["team"]);
    if ($branch != "Huron") {
        echo "<link rel='stylesheet' href='css/lobby.css'/>";
        echo "<link rel='stylesheet' href='/css/control.css'/>";
    }
    ?>
    <title>UMCU Lobby - <?php echo $branch; ?></title>
</head>
<body>
<header>
    <?php include "header.php" ?>
</header>
<div id="initialForm">
    <form autocomplete="off" spellcheck="false">
        <div>
            <label for="fname" title="First Name" data-alt="First"></label>
            <input type="text" id="fname"/>
            <label for="lname" title="Last Name" data-alt="Last"></label>
            <input type="text" id="lname"/>
            <select id="reason" name="reason" title="Reason for Visit"></select>
            <label for="addInfo">Empty</label>
            <input type="text" id="addInfo"/>
            <?php
            if ($_GET["branch"] == "William") {
                echo "<h3>Probably something extra here...</h3>";
            } else { ?>
                <!--<div class="switch" id="appointmentSwitch">
                    <div>Have an Appointment?</div>
                    <input id="toggle1" class="toggle toggle-yes-no" type="checkbox">
                    <label for="toggle1" data-on="Yes" data-off="No"></label>
                </div>-->
                <?php
            }
            ?>
            <div id="submitForm">Check-In</div>
        </div>
    </form>
</div>
<div id="thankYou">
    <h1>Thanks for Checking In</h1>
    <h1>Enjoy your time at UMCU!</h1>
</div>
<div id="viewVisitors"></div>
<form id="downloadReport" method="GET" action="/lobby/util/csvExport.php">
    <label for="reportStartDate">Start Date</label>
    <input type="date" id="reportStartDate" name="start" value="<?php echo date('Y-m-d'); ?>"/>
    <label for="reportEndDate">End Date</label>
    <input type="date" id="reportEndDate" name="end" value="<?php echo date('Y-m-d'); ?>"/>
    <!--<label for="branchList">Branch</label>-->
    <select id="branchList" name="branch" title="Branch List"></select>
    <input type="button" id="download" value="Download"/>
</form>
<div id="screensaver"></div>
<input type="text" id="decoy" title="" readonly/>
<input type="hidden" id="team" value="<?php echo $team ?>"/>
<input type="hidden" id="branch" value="<?php echo $branch; ?>"/>
<script src="/js/secure.js"></script>
<?php include "util/jquery.php"; ?>
<script src="js/lobby.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>