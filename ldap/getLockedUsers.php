<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 11/10/2016
 * Time: 2:02 PM
 */

global $ldapconn;
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
$baseDN = "DC=thedomain,DC=umcu,DC=org";
$allLocked = array();
$userLocations = array("OU=All Staff", "CN=Users", "OU=Administrators", "OU=Symitar", "OU=LSI");
$enabled = "(!(userAccountControl:1.2.840.113556.1.4.803:=2))";
//$ignore = "IUSR_NP00123F9EF87A";
$attributes = array(
    "distinguishedName",
    "samaccountname",
    //"lastlogontimestamp",
    "lockouttime",
    "lockoutdevice"
    //"badpasswordtime",
    //"badpwdcount"
);

if ($ldapconn) {
    $ldapbind = @ldap_bind($ldapconn, "CN=SU,OU=Administrators," . $baseDN, "C3t1@lph@V!$");
    if ($ldapbind) {
        foreach ($userLocations as $location) {
            $dn = $location . "," . $baseDN;
            //echo "<h3>Searching in: $dn</h3>";
            $filter = "(&(objectClass=user)$enabled(lockoutTime>=1))";
            $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
            if (!$ldapresults) die("Search Failed");
            //if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo "<br /><h3>No Locked Users in $location</h3>";
            else {
                //echo "<h3>Locked users in $location: " . ldap_count_entries($ldapconn, $ldapresults) . "</h3>";
                $results = ldap_get_entries($ldapconn, $ldapresults);
                $allLocked = array_merge($allLocked, $results);
                ldap_free_result($ldapresults);
            }
        }
    } else die("<h3>User Login Failed [" . ldap_error($ldapconn) . "]</h3>");
} else die("Failed to connect to Active Directory");
ldap_unbind($ldapconn);
myPrint($allLocked, $attributes);

function myPrint($results, $attributes) {
    if (sizeof($results) > 1) {
        echo "<div class='table'>";
        echo "<div class='row'>";
        echo "<div class='hcell opt'>Organizational Unit</div>";
        echo "<div class='hcell'>Name</div>";
        echo "<div class='hcell opt2'>Username</div>";
        echo "<div class='hcell time'>Lockout Time</div>";
        echo "<div class='hcell'>Lockout Device</div>";
        /*foreach ($attributes as $name) { if ($name != "distinguishedName" && $name != "samaccountname") echo "<div class='hcell'>$name</div>"; }*/
        echo "<div class='hcell'></div>";
        echo "</div>";
        foreach ($results as $key => $value) {
            if (is_array($value)) {
                $dn = $value["dn"];
                echo "<div class='row'>";
                foreach ($attributes as $name) {
                    if ($name == "distinguishedName") {
                        echo "<div class='cell opt'>" . getGroup($dn) . "</div>";
                        echo "<div class='cell opt2'>" . getName($dn) . "</div>";
                    } else if (stripos($name, "time")) {
                        echo "<div class='cell time'>" . formatTime($value[$name][0]) . "</div>";
                    } else echo "<div class='cell'>" . $value[$name][0] . "</div>";
                }
                echo "<div class='cell'><div class='unlock' data-dn='$dn'>Unlock</div></div>";
                echo "</div>"; // end row
            }
        }
        echo "</div>";
    }
    else {
        echo "<h1>No Locked Users</h1>";
    }
}
function prettyPrint($results, $a) {
    print "<pre>";
    print_r($results);
    print "</pre>";
}
function getName($dn) {
    $groups = "";
    $items = explode(",", $dn);
    foreach ($items as $item) {
        //echo "a[0]: " .  . "<br />";
        $type = explode("=", $item)[0];
        $name = explode("=", $item)[1];
        if ($type == "CN" && $name != "Users") {
            $groups .= $name;
        }
    }
    return $groups;
}
function getGroup($dn) {
    $groups = "";
    $items = explode(",", $dn);
    foreach ($items as $item) {
        $type = explode("=", $item)[0];
        $name = explode("=", $item)[1];
        if ($type == "OU" && $name != "All Staff") {
            $groups .= $name;
        }
    }
    return $groups;
}
function formatTime($time) {
    $windows_tick = 10000000;
    $sec_to_unix_epoch = 11644473600;
    $lockoutTime = strtotime("0 hours", $time / $windows_tick - $sec_to_unix_epoch);
    if (date("m-d-Y", $lockoutTime) == date("m-d-Y")) {
        $lockoutTime = date("g:i a", $lockoutTime);
    }
    else $lockoutTime = date("m-d-Y g:i a", $lockoutTime);
    return $lockoutTime;
}
function out($msg) {
    echo "<p>" . $msg . "</p>";
}