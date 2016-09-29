<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 4/5/2016
 * Time: 5:25 PM
 */

session_start();

if (isset($_SESSION["username"])) {
    session_unset();
    session_destroy();
    if (!isset($_SESSION["username"])) {
        session_start();
        $_SESSION["prevPage"] = $_POST["cp"];
        echo "logged out";
    } else echo $_SESSION["username"] . " is still logged in";
} else echo "No session set to begin";