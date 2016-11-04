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
    if (!isset($_SESSION["username"]))
        echo "logged_out";
}