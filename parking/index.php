<?php
$clientIP = $_SERVER['REMOTE_ADDR'];
$goto = "";
if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94") {
    //header("Location: ../video");
} else {
    $goto = $_GET["goto"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="../img/iconified/apple-touch-icon.png"/>
    <link rel="apple-touch-icon" sizes="57x57" href="../img/iconified/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="../img/iconified/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="../img/iconified/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="../img/iconified/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="../img/iconified/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="../img/iconified/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="../img/iconified/apple-touch-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/iconified/apple-touch-icon-180x180.png"/>
    <title>UMCU Parking App</title>
    <link rel="icon" href="//umculobby.com/favicon.ico">
    <link rel="stylesheet" href="//umculobby.com/css/reset.css"/>
    <link rel="stylesheet" href="//umculobby.com/css/font.css"/>
    <link rel="stylesheet" href="css/default.css"/>
    <link rel="stylesheet" href="css/screensaver.css"/>
    <link rel="stylesheet" href="css/map.css"/>
</head>
<body>
<header>
    <div id="timer"></div>
    <img src="img/umcu_logo.png" alt="UMCU Logo"/>
    <div id="closeReport">Check-In</div>
    <div id="report">Check-Out</div>
</header>
<div id="initialForm">
    <form id="parking" autocomplete="off">
        <div class="table" id="startInfo">
            <div class="row">
                <div class="cell">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" autocomplete="off">
                </div>
                <div class="cell">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="table" id="moreInfo">
            <div class="row">
                <div class="cell">
                    <label for="make">Car Make</label>
                    <input type="text" id="make" name="make">
                </div>
                <div class="cell">
                    <label for="model">Car Model</label>
                    <input type="text" id="model" name="model">
                </div>
            </div>
            <div class="row">
                <div class="cell" id="lv-cell">
                    <label for="last-visit">Last Visit</label>
                    <input type="text" id="last-visit" disabled>
                </div>
            </div>
        </div>
    </form>
    <div id="prompt"></div>
    <div id="search"></div>
    <div id="confirmation"></div>
</div>
<div id="parkingSelection">
    <div id="welcome"></div>
    <form id="parkingContainer" action="parking.php" method="post" onsubmit="return validateCheckIn()">
        <label for="spotNum">Spot Number</label>
        <select id="spotNum" name="spotNum"></select>
        <input type="number" id="other" name="other" title="Other Parking Spot" autocomplete="off"/>
        <input type="button" id="showMap" value="Show Parking Map"/>
        <label for="reason">Reason</label>
        <select id="reason" name="reason"></select>
        <input type="text" id="otherR" name="otherR" placeholder="Other Reason" autocomplete="off" maxlength="120"/>
        <div id="spotTaken"></div>
        <input type="hidden" id="branch" name="branch" value="<?php echo $_GET["branch"] ?>"/>
        <input type="submit" id="checkIn" value="Check-In"/>
        <input type="button" id="cancel" value="Cancel"/>
        <input type="text" id="vid" name="vid" title="" hidden/>
    </form>
</div>
<div id="viewVisitors"></div>
<div id="mapPopup">
    <div id="closeMap">Close</div>
    <div id="parking-map"></div>
</div>
<div id="screensaver"></div>
<input type="text" id="decoy" title="" readonly/>
<input type="text" id="goTo" title="" value="<?php echo $goto; ?>" readonly/>
<script src="/js/secure.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/map.js"></script>
<script src="js/parking.js"></script>
<script src="js/screensaver.js"></script>
</body>
</html>