<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/14/2016
 * Time: 2:50 PM
 */

if (isset($_SESSION)) {
    $currentUser = $_SESSION["username"];
    $authLevel = $_SESSION["authLv"];
    echo "<div id='current'>User: " . strtoupper($currentUser) . "</div>";
    if ($authLevel >= 50) {
        echo "<div class='button' id='upload'>Upload</div>";
        //echo "<div id='current'>User: " . strtoupper($cu) . "</div>";
        //echo "<div class='button' id='manage'>Manage</div>";
        if ($authLevel == 100) echo "<div class='button' id='new'>New User</div>";
    }
    echo "<div class='button' id='logout'>Logout</div>";
}
