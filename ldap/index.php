<?php
$clientIP = $_SERVER['REMOTE_ADDR'];
if ($clientIP != "198.111.188.194" && $clientIP != "198.0.123.94" && !startsWith($clientIP, "10.")) {
    //header("Location: ");
    die("<body style='background: #00274c;'><h1 style='color: #ffcb05; text-align: center;'>Not Authorized to Access this Resource from " . $clientIP . "</h1></body>");
}
function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unlock AD Users</title>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="ldap.css">
    <!--<link rel="stylesheet" href="/css/snow.css">-->
</head>
<body>
<div id="snow">
    <div id="message"></div>
    <div id="anonmessage"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="ldap.js"></script>
<script type="text/javascript">findLocked()</script>
</body>
</html>
