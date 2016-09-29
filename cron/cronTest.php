<?php

$val = $_GET["a"];

$subject = "Cron Job Test";
if ($val == "boom")
    $msg = "BOOM GOES THE DYNAMITE";
else $msg = "Hey there, I'm here to let you know that your cron job ran successfully. Have a nice day! :D\n";
$msg = wordwrap($msg, 70);
$emailTo = "abrainerd@umcu.org";
$emailFrom = "cron@umculobby.com";
$headers = "Reply-To: abrainerd@umcu.org\r\n";
$headers .= "From: UMCU Lobby <" . $emailFrom . ">\r\n";
$headers .= "Organization: UMCU\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

mail($emailTo, $subject, $msg, $headers);
