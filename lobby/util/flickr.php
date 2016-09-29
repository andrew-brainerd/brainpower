<?php
//header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

$req_url = 'https://www.flickr.com/services/oauth/request_token';
$authurl = 'https://www.flickr.com/services/oauth/authorize';
$acc_url = 'https://www.flickr.com/services/oauth/access_token';
$api_url = 'https://api.flickr.com/services/rest';
$conskey = 'e2a5b4662c632fc7330defeef5279e48';
$conssec = 'd8369c3540a5a19e';

session_start();

// In state=1 the next request should include an oauth_token.
// If it doesn't go back to 0
if (!isset($_GET['oauth_token']) && $_SESSION['state'] == 1) $_SESSION['state'] = 0;
try {
    $oauth = new OAuth($conskey, $conssec, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
    $oauth->enableDebug();
    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
        $request_token_info = $oauth->getRequestToken($req_url);
        $_SESSION['secret'] = $request_token_info['oauth_token_secret'];
        $_SESSION['state'] = 1;
        header('Location: ' . $authurl . '?oauth_token=' . $request_token_info['oauth_token']);
        exit;
    } else if ($_SESSION['state'] == 1) {
        $oauth->setToken($_GET['oauth_token'], $_SESSION['secret']);
        $access_token_info = $oauth->getAccessToken($acc_url);
        $_SESSION['state'] = 2;
        $_SESSION['token'] = $access_token_info['oauth_token'];
        $_SESSION['secret'] = $access_token_info['oauth_token_secret'];
    }
    $oauth->setToken($_SESSION['token'], $_SESSION['secret']);
    $oauth->fetch("$api_url/user.json");
    $json = json_decode($oauth->getLastResponse());
    print_r($json);
} catch (OAuthException $E) {
    print_r($E);
}

// Init cURL
/*
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
$opts =  $country . $nameSet . $gender;
$opts .=  $minAge . $maxAge . $output . $readable;
$url = "https://v5.fakenameapi.com/generate?" . $appInfo . $opts;

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