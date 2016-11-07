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
</head>
<body>
<table id="distances"></table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="js/secure.js"></script>
<script src="js/location.js"></script>
<script type="text/javascript">getLocation();</script>
</body>
</html>