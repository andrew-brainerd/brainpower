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
            user-select: none;
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

encodeUserInfo("All Team", "umcu", "aMAIZEing");
encodeUserInfo("IT", "it", "b33pb00p");

function encodeUserInfo($acct, $un, $pw)
{
    echo "<h4>$acct</h4>";
    $loginInfo = json_encode(array("un" => "$un", "pw" => "$pw"));
    $url = "https://umculobby.com/video/util/auth.php?key=" . base64url_encode($loginInfo);
    $msg = "<a href='" . $url . "' target='_blank' class='libraryLink'>UMCU Video Library</a>";
    echo $msg . "<br><br>";
}
function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/*function encodeVideoInfo($vid)
{
    $login = encodeUserInfo("All Team", "umcu", "aMAIZEing");
    $data = $login . "&v=" . $vid;
    $encodedData = base64url_encode($data);
    $base = "https://umculobby.com/video/util/auth.php?key=";
    $url = $base . $encodedData;
    return $msg = "<a href='" . $url . "' target='_blank'>UMCU<br>Video Library</a>";
}*/
?>
</body>
</html>

<!--
Unused, possibly useful PHP
//$plain = $base . $plainU . $plainP;
//$style = "background: #00274c;border-radius: 5px;color: #ffcb05;display: block;"
//$style .= "font-family: 'Caveat Brush', cursive;font-size: 24px;height: 100px;line-height: 100px;"
//$style .= "text-align: center;text-decoration: none;transition: background 0.5s, color 0.3s;width: 200px;";
//$msg = "<a href='" . $url . "' target='_blank' id='libraryLink' style='" . $style . "'>UMCU Video Library</a>";
-->