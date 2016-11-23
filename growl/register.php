<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 11/23/2016
 * Time: 2:16 PM
 */

require_once 'Net/Growl/Autoload.php';

$notifications = array(
    'GROWL_NOTIFY_PHPERROR'
);
$appName  = 'PHP App Example using GNTP';
$password = '';

$app = new Net_Growl_Application(
    $appName,
    $notifications,
    $password
);
$options = array(
    'protocol' => 'gntp',
    'timeout'  => 15,
);

$growl = Net_Growl::singleton($app, null, null, $options);
$growl->register();