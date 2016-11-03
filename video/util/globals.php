<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 5/11/2016
 * Time: 10:16 AM
 */
$function = strip_tags($_GET["f"]);
if ($function == "sendEmail") {
    if (sendEmail(strip_tags($_GET["to"]), strip_tags($_GET["from"]), "", "Test Message"))
        echo "Success";
    else echo "Failure";
}

function sendUpdateEmail($msg, $subject)
{
    $content = $msg;
    $msg = "<html><head>";
    //$msg .= '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Caveat+Brush">';
    $msg .= '<style type="text/css">';
    $msg .= "body { font-family: cursive; font-size: 26px; line-height: 100px; text-align: center; text-decoration: none; }";
    $msg .= "</style></head>";
    $msg .= "<body>";
    $msg .= $content;
    $msg .= "</body></html>";
    $msg = wordwrap($msg, 70);
    sendEmail("abrainerd@umcu.org", "video@umculobby.com", $subject, $msg, "html");
}
function sendEncodedLink($link, $subject)
{
    $msg = "<html><head><style type='text/css'>";
    $msg .= "table { background-color: #00274c; padding: 10px; text-align: center; width: 200px; } ";
    $msg .= "a { text-decoration: none; color: #ffcb05; font-family: cursive; font-size: 24px; } ";
    $msg .= "table td { padding: 7px; } ";
    $msg .= "</style></head><body>";
    $msg .= "<table title=$subject><tr><td>" . $link . "</td></tr></table>";
    $msg .= "</body></html>";
    //sendEmail("abrainerd@umcu.org, cardahl@umcu.org", "video@umculobby.com", $subject, $msg, "html");
    return $msg;
}
function setHeaders($emailFrom, $type)
{
    $headers = "Reply-To: UMCU <" . $emailFrom . ">\r\n";
    $headers .= "Return-Path: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "From: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "Organization: UMCU\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/" . $type . "; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    return $headers;
}
function sendEmail($to, $from, $subject, $msg, $type = "plain")
{
    $emailTo = $to;
    $emailFrom = $from;
    $headers = setHeaders($emailFrom, $type);
    return mail($emailTo, $subject, $msg, $headers);
}