<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 2/26/2016
 * Time: 5:02 PM
 */

function sendLogEmail($fn, $ln, $mk, $md, $ps, $r)
{
    // the message
    //$msg = "Visitor Check-In at Front Desk\n";
    $msg = $fn . " " . $ln . " checked in at the front desk.<br>\n";
    $msg .= "Vehicle: " . $mk . " " . $md . "<br>\n";
    $msg .= "Parking Spot: " . $ps . "<br>\n";
    $msg .= "Reason: " . $r . "<br>\n";
    $msg .= "<br><br><a href='https://umculobby.com/parking/index.php?goto=view'>View Today's Check-Ins</a>";
    //$msg .= "\n\n <a href='http://notmuchhappening.com/umcu/parking/index.php?goto=view'>View Today's Check-Ins</a>";

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg, 70);
    $emailTo = "abrainerd@umcu.org";//, drwb333@gmail.com";
    $emailFrom = "checkin@umculobby.com";
    //$headers = "From: " . $emailFrom;

    $headers = "Reply-To: UMCU <" . $emailFrom . ">\r\n";
    $headers .= "Return-Path: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "From: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "Organization: UMCU\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    //$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    //$subject = "UMCU Check-In at " . $ti;
    $subject = "Visitor at Front Desk";
    // send email
    mail($emailTo, $subject, $msg, $headers);
}

function sendLogText($fn, $ln, $mk, $md, $ps, $r)
{
    $msg = "Name:   " . $fn . " " . $ln . "\n";
    $msg .= "Vehicle: " . $mk . " " . $md . "\n";
    $msg .= "Spot:     " . $ps . "\n";
    $msg .= "Reason: " . $r . "\n";

    //$msg = wordwrap($msg,70);
    $emailTo = "9897210902@vtext.com";
    if (strpos($_SERVER["HTTP_HOST"], "notmuch") == false)
        $emailFrom = "checkin@umculobby.com";
    else $emailFrom = "checkinDEV@umculobby.com";
    $headers = "From: The UMCU <" . $emailFrom . ">\r\n";

    mail($emailTo, "", $msg, $headers);
}

function sendMessageText($m)
{
    $msg = $m;
    $emailTo = "9897210902@vtext.com";
    $emailFrom = "abrainerd@umcu.org";
    $headers = "From: The UMCU <" . $emailFrom . ">\r\n";

    mail($emailTo, "", $msg, $headers);
}

function sendFacilitesEmail($fn, $ln, $ps, $as, $vd, $ra)
{
    $subject = "Assigned Parking Spot Taken";

    $name = $fn . " " . $ln;
    $msg = "<html><head><style>";
    $msg .= "table { border-collapse: collapse; }";
    $msg .= "table td { padding: 5px; }";
    $msg .= "table tr td:first-child { text-align: right; }";
    $msg .= "table tr td:nth-child(2) { padding-left: 10px; }";
    $msg .= "</style></head><body><table style='font-size: 20px;'>";
    $msg .= "<tr><td><b>Team Member:</b></td><td>" . $name . "</td></tr>\n";
    $msg .= "<tr><td><b>Current Spot:</b></td><td>" . $ps . "</td></tr>\n";
    $msg .= "<tr><td><b>Assigned Spot:</b></td><td>" . $as . "</td></tr>\n";
    $msg .= "<tr><td><b>Vehicle in Spot:</b></td><td>" . $vd . "</td></tr>\n";
    $msg .= "</table>";
    $msg .= "<br><br><a href='https://umculobby.com/parking/index.php?goto=view'>View Today's Check-Ins</a>";
    $msg .= "</body></html>";

    //$msg = wordwrap($msg,70);
    $emailTo = "abrainerd@umcu.org, facilities@umcu.org";
    $emailFrom = "checkin@umculobby.com";
    $headers = "Reply-To: " . $name . " <" . $ra . ">\r\n";
    $headers .= "From: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "Organization: UMCU\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    mail($emailTo, $subject, $msg, $headers);
    sendTeamMemberEmail($fn, $ra);
}

function sendTeamMemberEmail($name, $tmEmail)
{
    $subject = "Assigned Parking Spot Taken";

    $msg = "The fantastic Facilities team has been notified that your assigned parking spot ";
    $msg .= "was unavailable for your use. They will let you know when it is open again.\n\n";
    $msg .= "Thanks for using the UMCU Parking Application " . $name . "!\n";

    $emailTo = $tmEmail;
    $emailFrom = "checkin@umculobby.com";
    $headers = "Reply-To: App Creator <" . "abrainerd@umcu.org" . ">\r\n";
    $headers .= "From: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "Organization: UMCU\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    mail($emailTo, $subject, $msg, $headers);
}

function sendFacilitesEmailTO($fn, $ln, $ps, $vd, $ra)
{
    $name = $fn . " " . $ln;
    $msg = "Name: " . $name . "\n";
    $msg .= "Vehicle: " . $vd . "\n";
    $msg .= "Assigned Spot: " . $ps . "\n";

    //$msg = wordwrap($msg,70);
    $emailTo = "drwb333@gmail.com, abrainerd@umcu.org, facilities@umcu.org";
    $emailFrom = "checkin@umculobby.com";
    $headers = "Reply-To: " . $name . " <" . $ra . ">\r\n";
    $headers .= "From: UMCU Lobby <" . $emailFrom . ">\r\n";
    $headers .= "Organization: UMCU\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    $subject = "Assigned Parking Spot Taken";

    mail($emailTo, $subject, $msg, $headers);
}


function sendReasonUpdate($r)
{
    $msg = "Consider adding new reason to dropdown\n\n";
    $msg .= "Reason: " . $r . "\n";

    //$msg = wordwrap($msg,70);
    $emailTo = "9897210902@vtext.com";
    $emailFrom = "checkin@umculobby.com";
    $headers = "From: The UMCU <" . $emailFrom . ">\r\n";

    mail($emailTo, "", $msg, $headers);
}