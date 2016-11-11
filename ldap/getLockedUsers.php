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
$userLocations = array("OU=All Staff", "CN=Users", "OU=Administrators");
$enabled = "(!(userAccountControl:1.2.840.113556.1.4.803:=2))";
$ignore = "IUSR_NP00123F9EF87A";
$attributes = array(
    "distinguishedName",
    "samaccountname",
    //"lastlogontimestamp",
    "lockouttime",
    //"badpasswordtime",
    //"badpwdcount"
);

if ($ldapconn) {
    $ldapbind = @ldap_bind($ldapconn, "CN=Andrew Brainerd,CN=Users," . $baseDN, "b0ggl3sth3m!nd");
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
        echo "<div class='hcell'>Organizational Unit</div>";
        echo "<div class='hcell'>Name</div>";
        echo "<div class='hcell'>Username</div>";
        echo "<div class='hcell'>Lockout Time</div>";
        /*foreach ($attributes as $name) {
            if ($name != "distinguishedName" && $name != "samaccountname") echo "<div class='hcell'>$name</div>";
        }*/
        echo "<div class='hcell'></div>";
        echo "</div>";
        foreach ($results as $key => $value) {
            if (is_array($value)) {
                $dn = $value["dn"];
                echo "<div class='row'>";
                foreach ($attributes as $name) {
                    if ($name == "distinguishedName") {
                        echo "<div class='cell'>" . getGroup($dn) . "</div>";
                        echo "<div class='cell'>" . getName($dn) . "</div>";
                    } else if (stripos($name, "time")) {
                        echo "<div class='cell'>" . formatTime($value[$name][0]) . "</div>";
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
    return date("m-d-Y h:i", $time / 10000000 - 11644473600);
}
function out($msg) {
    echo "<p>" . $msg . "</p>";
}