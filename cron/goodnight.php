<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/20/2016
 * Time: 6:25 PM
 */

goodnight("andrew");
//goodnight("kurtis");

function goodnight($person)
{
    $emailFrom = "walter@umculobby.com";
    $headers = "From: Walter <" . $emailFrom . ">\r\n";
    $msg = "Fail";
    $emailTo = "9897210902@vtext.com";
    switch ($person) {
        case "andrew":
            $msg = "Good night sir. May your dreams be filled with sunny weather and ice cream";
            $emailTo = "9897210902@vtext.com";
            mail($emailTo, "", $msg, $headers);
            break;
        case "kurtis":
            $msg = "Hello Kurtis. My name is Walter. I want to wish you a good night and pleasant dreams.";
            $msg .= " Also, I hear you like ducks. I can make a duck sound. *Quack quack*";
            $emailTo = "9892771761@vtext.com";
            mail($emailTo, "", $msg, $headers);
            break;
        /*case "carrie":
            $msg = "Hello Carrie. My name is Walter. I want to wish you a good night and pleasant dreams.";
            $msg .= " Also, I hear you like running. Here's a running joke:";
            $msg2 = "Did you hear about the race between the lettuce and the tomato?";
            $msg3 = " The lettuce was a \"head\" and the tomato was trying to \"ketchup\"!";
            //$emailTo = "7347302907@vtext.com";
            mail($emailTo, "", $msg, $headers);
            sleep(10);
            mail($emailTo, "", $msg2, $headers);
            sleep(5);
            mail($emailTo, "", $msg3, $headers);
            break;
        */
    }
}