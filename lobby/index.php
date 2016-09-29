<?php
$clientIP = $_SERVER['REMOTE_ADDR'];
$goTo = "";
if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94") {
    //header("Location: ../video");
} else {
    $goTo = $_GET["goto"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"; ?>
    <title>UMCU Lobby Check-In</title>
</head>
<body>
<header>
    <div id="timer"></div>
    <img src="img/umcu_logo.png" alt="UMCU Logo"/>
    <span><?php //echo $_GET["location"]; ?></span>
    <!--<img src="img/UMCU-NewLogo-transparent2.png" />-->
    <div id="closeReport">Check-In</div>
    <div id="report">Check-Out</div>
</header>
<div id="initialForm">
    <form autocomplete="off" spellcheck="false">
        <div>
            <label for="fname">First Name</label>
            <input type="text" id="fname"/>
            <label for="lname">Last Name</label>
            <input type="text" id="lname"/>
            <select id="reason" name="reason"></select>
            <input type="text" id="other" placeholder="Other Reason"/>
            <div id="submitForm">Check-In</div>
        </div>
    </form>
</div>
<div id="thankYou">
    <h1>Thanks for Checking In</h1>
    <h1>Enjoy your time at UMCU!</h1>
</div>
<div id="viewVisitors"></div>
<div id="screensaver"></div>
<input type="text" id="decoy" readonly/>
<input type="hidden" id="branch" value="<?php echo $_GET["branch"] ?>"/>
<input type="hidden" id="goTo" value="<?php echo $goTo; ?>"/>
<script src="/js/secure.js"></script>
<?php include "util/jquery.php"; ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>-->
<script src="js/script.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>