<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 11/23/2016
 * Time: 2:16 PM
 */

include "class.growl.php";

$growl = new Growl();
//$growl->setAddress("127.0.0.1");
$growl->setAddress("10.16.10.16");
$growl->addNotification("Test");
$growl->register();

$growl->notify("Test", "Test Alert", "The body of the test alert!");