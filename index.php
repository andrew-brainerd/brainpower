<?php
$clientIP = $_SERVER['REMOTE_ADDR'];
if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94") {
    //header("Location: video");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="apple-touch-icon" href="img/iconified/apple-touch-icon.png"/>
    <link rel="apple-touch-icon" sizes="57x57" href="img/iconified/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="img/iconified/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="img/iconified/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="img/iconified/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="img/iconified/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="img/iconified/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="img/iconified/apple-touch-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="img/iconified/apple-touch-icon-180x180.png"/>
    <title>Location Identifier</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Permanent+Marker">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Oswald:700">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Caveat+Brush">
    <link rel="stylesheet" type="text/css" href="css/landing.css">
    <style>
        html {
            overflow-y: scroll;
        }
        body {
            display: none;
        }

        h1, h3 {
            color: white;
            font-size: 24vw;
            margin-top: 50px;
            text-align: center;
            /*text-rendering: optimizeLegibility;*/
            -webkit-font-smoothing: antialiased;
        }

        h3 {
            font-size: 4vw;
        }

        #continue {
            background: #ffcb05;
            border: 2px solid #ffcb05;
            border-radius: 5px;
            color: #00274c;
            cursor: pointer;
            display: block;
            font-size: 30px;
            -webkit-appearance: none;
            margin: 70px auto;
            padding: 15px;
            text-align: center;
            width: 200px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
    <script type="text/javascript">
        function transfer(site) {
            if (site == "parking") {
                location.href += "/parking";
            }
            else if (site == "video") {
                location.href += "/video";
            } else console.log("Something broke :(");
        }
    </script>
</head>
<body>
<!--
    <div id="container">
        <div id="parking" class="nav" onclick="transfer('parking')">
            <div class="title">Parking</div>
            <img src="img/parking.svg"/>
        </div>
        <div id="video" class="nav" onclick="transfer('video')">
            <div class="title">Video</div>
            <img src="img/video.svg"/>
        </div>
    </div>

<div id="continue">Continue</div>-->
<table id="distances"></table>
<p id="credit">Icons made by Freepik from www.flaticon.com</p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="js/secure.js"></script>
<script src="js/location.js"></script>
<!--<script src="video/js/auth.js"></script>-->
<script type="text/javascript">getLocation();</script>
</body>
</html>