<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 5/4/2016
 * Time: 4:05 PM
 */

// Init cURL
$ch = curl_init();

// Set cURL Options
$appID = "1898ec66";
$appKey = "713b2c77af8e71e6441051260e7b4c76";
$country = "&country=us";
$nameSet = "&name-set=us";
$gender = "&gender=random";
$minAge = "&minimum-age=19";
$maxAge = "&maximum-age=85";
$output = "&output=json";
$readable = "";//"&human=true";

$appInfo = "app_id=" . $appID . "&app_key=" . $appKey;
$opts = $country . $nameSet . $gender;
$opts .= $minAge . $maxAge . $output . $readable;
$url = "https://v5.fakenameapi.com/generate?" . $appInfo . $opts;

echo $url;

curl_setopt_array($ch, array(
    CURLOPT_HEADER => 0,
    CURLOPT_USERAGENT => "curl/7.35.0",
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url
));

// Execute cURL
$result = curl_exec($ch);

if ($result != false) {
    //echo "<div id='url'>" . $url . "</div>";
    echo $result;
}
//else echo "Error: " . curl_error($ch);

// Close cURL
curl_close($ch);

/*
File stuff

$fp = fopen("htmloutput.txt", "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
fclose($fp);

*/