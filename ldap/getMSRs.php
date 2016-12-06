<!DOCTYPE html>
<html>
<head>
    <title>AD - Get MSRs</title>
    <link rel="stylesheet" href="ldap.css">
    <style type="text/css">
        body {
            font-size: 1.3vw;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
<?php
global $ldapconn;
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
$baseDN = "DC=thedomain,DC=umcu,DC=org";
$msrList = array();
$userLocations = array("OU=All Staff", "CN=Users", "OU=Administrators", "OU=Symitar", "OU=LSI");
$enabled = "(!(userAccountControl:1.2.840.113556.1.4.803:=2))";
$attributes = array(
    "distinguishedName",
    //"uid",
    //"givenname",
    "department",
    "samaccountname",
    "description",
    //"mail",
    //"lastlogontimestamp",
    //"lockouttime",
    //"badpasswordtime",
    //"badpwdcount",
    "jpegphoto"
    //"nsaccountlock",
    //"mobile"
);
$roles = "(|(description=MSR)(description=Branch Manager)(description=Assistant Manager))";
$filter = "(&(objectClass=user)$roles$enabled)";
echo "<h3>Filter:$filter</h3>";

if ($ldapconn) {
    $ldapbind = @ldap_bind($ldapconn, "CN=SU,OU=Administrators," . $baseDN, "C3t1@lph@V!$");
    if ($ldapbind) {
        foreach($userLocations as $location) {
            $dn = $location . "," . $baseDN;
            $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
            if (!$ldapresults) die("Search Failed");
            else {
                $results = ldap_get_entries($ldapconn, $ldapresults);
                $msrList = array_merge($msrList, $results);
                ldap_free_result($ldapresults);
            }
        }
    } else echo "<h3>User Login Failed [" . ldap_error($ldapconn) . "]</h3>";
} else echo "Failed to connect to Active Directory";
ldap_unbind($ldapconn);
myPrint($msrList, $attributes);

function myPrint($results, $attributes) {
    echo "<div class='table'>";
    echo "<div class='row'>";
    echo "<div class='hcell'>Organizational Unit</div>";
    echo "<div class='hcell'>Name</div>";
    foreach ($attributes as $name) {
        if ($name != "distinguishedName" && $name != "jpegphoto") echo "<div class='hcell'>$name</div>";
    }
    echo "</div>";
    foreach ($results as $key => $value) {
        if (is_array($value)) { // && getGroup($value["dn"]) == "Information Technology") {
            $accountName = $value["samaccountname"][0];
            $image = base64_encode($value["jpegphoto"][0]);
            //echo "<img src='data:image/jpeg;base64,$image'/>";
            echo "<div class='row' data-img-src='data:image/jpeg;base64,$image'>";
            foreach ($attributes as $name) {
                if ($name == "distinguishedName") {
                    echo "<div class='cell'>" . getGroup($value["dn"]) . "</div>";
                    echo "<div class='cell'>" . getName($value["dn"]) . "</div>";
                } else if ($name != "jpegphoto") {
                    if ($name == "lockouttime" || $name == "badpasswordtime" || $name == "lastlogontimestamp") {
                        echo "<div class='cell' data-name='$name'>" . formatTime($value[$name][0]) . "</div>";
                    } else echo "<div class='cell' data-name='$name'>" . $value[$name][0] . "</div>";
                }
            }
            echo "</div>"; // end row
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
        //echo "a[0]: " .  . "<br />";
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
    //$dn = "CN=$username,OU=Information Technology,OU=All Staff,DC=thedomain,DC=umcu,DC=org";
    //$dn = "CN=$username,CN=Users,DC=thedomain,DC=umcu,DC=org";
    /*foreach ($results as $key => $value) {
            if ($key != "count") {
                echo $key . ": " . $value["mail"][0] . "<br />";
            }
        }*/
    //out("Distinguished Name: " . $results[0]["dn"]);
    //$filter = '(&(uid=%s))'; //(objectClass=posixAccount))';
    //ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
    //ldap_set_option(NULL, LDAP_OPT_TIMELIMIT, 4);
    //ldap_set_option(NULL, LDAP_OPT_NETWORK_TIMEOUT, 4);
    //ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
    //$trimmerdUsername = trim(preg_replace('/[^a-zA-Z0-9\-\_@\.]/', '', $username));
    //$filter = str_replace('%s', "abrainerd", $filter);
    //$filter = "(|(sn=Andrew Brainerd*)(givenname=*))";
    //$filter = "(|(mail=*)";
    //echo "<br />Trimmed: $trimmerdUsername";
}
?>
</body>
</html>
