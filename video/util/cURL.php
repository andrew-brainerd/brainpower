<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 5/11/2016
 * Time: 11:11 AM
 */

$ch = curl_init();
$user = "username=umcu";
$pass = "password=aMAIZEing";
$url = "https://umculobby.com/video/util/login.php/?" . $user . "&" . $pass;

curl_setopt_array($ch, array(
    CURLOPT_POST => 0,
    CURLOPT_HEADER => 0,
    CURLOPT_USERAGENT => "curl/7.35.0",
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url
));

// Execute cURL
$result = curl_exec($ch);
session_start();
session_id($result);

if ($result != false) {
    //echo "<div id='url'>" . $url . "</div>";
    echo "**************************** Returned From Call ****************************<br>";
    echo $result . "<br><br>";
    echo "**************************************************************************<br>";
} else echo "Error: " . curl_error($ch);

// Close cURL
curl_close($ch);