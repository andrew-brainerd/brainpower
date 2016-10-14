<?php
//$clientIP = $_SERVER['REMOTE_ADDR'];
//$goTo = "";
//$branch = "";
/*if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94") {
    //header("Location: ../video");
} else {*/
    $goTo = strip_tags($_GET["goto"]);
    $_GET["branch"] = strip_tags($_GET["branch"]);
    $branch = $_GET["branch"];
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "head.php";
    if ($branch != "Huron") echo "<link rel='stylesheet' href='css/lobby.css'/>";
    ?>
    <title>UMCU Lobby Check-In</title>
</head>
<body>
<header>
    <?php include "header.php" ?>
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
<div id="screensaver"></div>
<input type="text" id="decoy" title="" readonly/>
<input type="hidden" id="branch" value="<?php echo $branch ?>"/>
<input type="hidden" id="goTo" value="<?php echo $goTo; ?>"/>
<script src="/js/secure.js"></script>
<?php include "util/jquery.php"; ?>
<script src="js/lobby.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>