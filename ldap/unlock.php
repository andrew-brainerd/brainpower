<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 11/10/2016
 * Time: 2:02 PM
 */

global $ldapconn;
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");

if ($ldapconn) {
    $dn = "DC=thedomain,DC=umcu,DC=org";
    $ldapbind = @ldap_bind($ldapconn, "CN=Andrew Brainerd,CN=Users," . $dn, "b0ggl3sth3m!nd");
    if ($ldapbind) {
        $dn = "OU=Administrators,DC=thedomain,DC=umcu,DC=org"; // CN=Users,
        $enabled = "(!(userAccountControl:1.2.840.113556.1.4.803:=2))";
        $filter = "(&(objectClass=user)$enabled(samaccountname=*admin*)(|(lockoutTime>=1)(badpwdcount>=2)))";
        echo "<h3>Filter:$filter</h3>";
        $attributes = array(
            "distinguishedName",
            "samaccountname",
            "lastlogontimestamp",
            "lockouttime",
            "badpasswordtime",
            "badpwdcount"
        );
        $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
        if (!$ldapresults) die("Search Failed");
        if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo "<br /><h3>No users locked</h3>";
        else {
            $results = ldap_get_entries($ldapconn, $ldapresults);
            ldap_free_result($ldapresults);
            myPrint($results, $attributes);
        }
    } else echo "<h3>User Login Failed [" . ldap_error($ldapconn) . "]</h3>";
} else echo "Failed to connect to Active Directory";
mail("9897210902@vtext.com", "", "Unlocked $dn", "From: Perry <lobby.ucmu.org>\r\n");

function myPrint($results, $attributes) {
    global $ldapconn;
    echo "<div class='table'>";
    echo "<div class='row'>";
    echo "<div class='hcell'>Organizational Unit</div>";
    echo "<div class='hcell'>Name</div>";
    foreach ($attributes as $name) {
        if ($name != "distinguishedName") echo "<div class='hcell'>$name</div>";
    }
    echo "</div>";
    foreach ($results as $key => $value) {
        if (is_array($value)) {
            $dn = $value["dn"];
            foreach ($attributes as $name) {
                if ($name == "distinguishedName") {
                    echo "<div class='cell'>" . getGroup($dn) . "</div>";
                    echo "<div class='cell'>" . getName($dn) . "</div>";
                } else if (stripos($name, "time")) {
                    echo "<div class='cell'>" . formatTime($value[$name][0]) . "</div>";
                } else echo "<div class='cell'>" . $value[$name][0] . "</div>";
            }
            echo "</div>"; // end row
            $entries = array(
                "lockouttime" => 0
            );
            if (ldap_modify($ldapconn, $dn, $entries)) {
                echo "<h3>Unlocked</h3>";
            } else {
                echo "<h3>Did not change $dn</h3><h3>" . ldap_error($ldapconn) . "</h3>";
            }
        }
    }
    echo "</div>";
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