<?php
$clientIP = $_SERVER['REMOTE_ADDR'];
$goTo = "";
$branch = "";
if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94") {
    //header("Location: ../video");
} else {
    $goTo = strip_tags($_GET["goto"]);
    $branch = strip_tags($_GET["branch"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"; ?>
    <link rel="stylesheet" href="css/lobby.css"/>
    <title>UMCU Lobby Check-In</title>
</head>
<body>
<header>
    <div id="timer"></div>
    <img src="img/umcu_logo.png" alt="UMCU Logo"/>
    <!--<img src="img/UMCU-NewLogo-transparent2.png" />-->
    <div id="closeReport">Check-In</div>
    <div id="report">Check-Out</div>
</header>
<div id="initialForm">
    <?php
    if ($branch != "Huron") include "lobby.php";
    ?>
</div>
<div id="thankYou">
    <h1>Thanks for Checking In</h1>
    <h1>Enjoy your time at UMCU!</h1>
</div>
<div id="viewVisitors"></div>
<div id="closingNotes">
    <label for="notes">In what ways were you able to aMAIZEing this member today?</label>
    <textarea id="notes"></textarea>
</div>
<div id="screensaver"></div>
<input type="text" id="decoy" title="" readonly/>
<input type="hidden" id="branch" value="<?php echo $branch ?>"/>
<input type="hidden" id="goTo" value="<?php echo $goTo; ?>"/>
<script src="/js/secure.js"></script>
<?php include "util/jquery.php"; ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>-->
<script src="js/lobby.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>