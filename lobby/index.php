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
    $team = strip_tags($_GET["team"]);
    ?>
    <link rel='stylesheet' href='css/lobby.css'/>
    <link rel='stylesheet' href='/css/control.css'/>
    <title></title>
</head>
<body>
<header>
    <?php include "header.php" ?>
</header>
<div id="initialForm">
    <?php include "lobby.php"; ?>
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
<script src="/js/secure.js"></script>
<?php include "util/jquery.php"; ?>
<script src="js/lobby.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>