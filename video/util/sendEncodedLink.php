<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Caveat+Brush">
    <style type="text/css">
        .libraryLink {
            background: #00274c;
            border-radius: 5px;
            color: #ffcb05;
            display: block;
            font-family: 'Caveat Brush', cursive;
            font-size: 24px;
            line-height: 100px;
            text-align: center;
            text-decoration: none;
            transition: background 0.5s, color 0.3s;
            width: 200px;
        }

        .libraryLink:hover {
            background-color: #ffcb05;
            color: #00274c;
        }

        .sentHTML {
            border: 4px solid purple;
            padding: 30px;
        }
    </style>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 5/5/2016
 * Time: 7:19 PM
 */

include "globals.php";

//echo "<div class='sentHTML'>" . sendEncodedLink(encodeVideoInfo(3), "Video Library Auto Login") . "</div>";

encodeUserInfo("All Team", "umcu", "aMAIZEing");
encodeUserInfo("IT", "it", "b33pb00p");
if ($_GET["me"] == "admin")
    encodeUserInfo("ADMIN", "admin", "b0ggl3sth3m!nd");
//encodeVideoInfo(3);
//encodeUserInfo("User 1", "user1", "password");
//encodeUserInfo("IT", "it", "b33pb00p");

function encodeVideoInfo($vid)
{
    $login = encodeUserInfo("All Team", "umcu", "aMAIZEing");
    $data = $login . "&v=" . $vid;
    $encodedData = base64url_encode($data);
    $base = "https://umculobby.com/video/?";
    $url = $base . $encodedData;
    return $msg = "<a href='" . $url . "' target='_blank'>UMCU<br>Video Library</a>";
    //echo $data . "<br><br>";
    //echo "<a href='" . $url . "' target='_blank'>View Blooper Video</a><br>";
    //echo "<a href='http://umcu.notmuchhappening.com/video/util/auth.php?cp=" . $url . "' target='_blank'>Auth Test</a><br><br>";
}

function encodeUserInfo($acct, $un, $pw)
{
    echo "<h4>" . $acct . "</h4>";
    $plainU = "u=" . $un;
    $plainP = "&p=" . $pw;
    //$u = urlencode(base64_encode($plainU));
    //$p = urlencode(base64_encode($plainP));
    $base = "https://umculobby.com/video/?";
    $plainInfo = $plainU . $plainP;
    $encodedinfo = base64url_encode($plainInfo);
    $url = $base . $encodedinfo;
    $msg = "<a href='" . $url . "' target='_blank'>" . $url . "</a>";
    $plain = $base . $plainU . $plainP;
    //echo $plain . "<br><br>";
    //echo $msg . "<br><br>";
    $style = "background: #00274c;border-radius: 5px;color: #ffcb05;display: block;font-family: 'Caveat Brush', cursive;font-size: 24px;height: 100px;line-height: 100px;text-align: center;text-decoration: none;transition: background 0.5s, color 0.3s;width: 200px;";
    //$msg = "<a href='" . $url . "' target='_blank' id='libraryLink' style='" . $style . "'>UMCU Video Library</a>";
    $msg = "<a href='" . $url . "' target='_blank' class='libraryLink'>UMCU Video Library</a>";
    echo $msg . "<br><br>";
    //echo "<a href='http://umcu.notmuchhappening.com/video/util/auth.php?cp=" . $url . "' target='_blank'>Auth Test</a><br><br>";
    return $plainInfo;
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}


?>
</body>
</html>
