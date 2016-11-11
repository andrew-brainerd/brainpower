<?php
//define(LDAP_OPT_DIAGNOSTIC_MESSAGE, 0x0032);
//echo "<h1>Current User: " . $_SERVER['AUTH_USER'] . "</h1>";
$username = $_GET["username"];
$password = $_GET["password"];
global $ldapconn;
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");

if ($ldapconn) {
    $dn = "DC=thedomain,DC=umcu,DC=org";
    $ldapbind = @ldap_bind($ldapconn, "CN=Andrew Brainerd,CN=Users," . $dn, "b0ggl3sth3m!nd");
    if ($ldapbind) {
        //echo "<h5>User Verified via Active Directory</h5>";
        $dn = "OU=Administrators,DC=thedomain,DC=umcu,DC=org"; // CN=Users,
        $enabled = "(!(userAccountControl:1.2.840.113556.1.4.803:=2))";
        $filter = "(&(objectClass=user)$enabled)";
        //$filter = "(&(objectClass=user)(lockoutTime>=1))";
        //$filter = "(&(objectCategory=person)(objectClass=User)(lockoutTime>=1))";
        $filter = "(&(objectClass=user)$enabled(samaccountname=*admin*)(lockoutTime>=1))"; // (objectCategory=person)
        echo "<h3>Filter:$filter</h3>";

        $attributes = array("distinguishedName", //"organizationalUnit",
            //"objectClass",
            //"uid",
            //"givenname",
            "samaccountname", "mail", "lastlogontimestamp", "lockouttime", //"badpasswordtime",
            //"badpwdcount",
            //"jpegphoto"
            //"nsaccountlock",
            //"mobile"
        );
        $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
        if (!$ldapresults) die("Search Failed"); //else echo "<br />Performed a search";
        if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo "<br />No users with that information found"; else {
            $results = ldap_get_entries($ldapconn, $ldapresults);
            ldap_free_result($ldapresults);
            //if ($results["count"] > 1) echo "<br />" . $results["count"] . " records found";
            if (false === $results) echo "no result set found";
            if ($password == null) myPrint($results, $attributes, $username); else tryLogin($results, $dn, $username, $password);
        }

        /*$dn = "DC=Users,DC=thedomain,DC=umcu,DC=org";
        $attributes = array(
            "distinguishedName",
            "organizationalUnit",
            "objectClass"
        );
        $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
        if (!$ldapresults) echo "<br />Super Search Fail"; //else echo "<br />Performed a search";
        if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo "<br />No users with that information found";
        else {
            $results = ldap_get_entries($ldapconn, $ldapresults); ldap_free_result($ldapresults);
            //if ($results["count"] > 1) echo "<br />" . $results["count"] . " records found";
            myPrint($results, $attributes, $username);
            //prettyPrint($results);
        }*/
    } else echo "<h3>User Login Failed [" . ldap_error($ldapconn) . "]</h3>";
} else echo "Failed to connect to Active Directory";

function tryLogin($results, $dn, $username, $password) {
    global $ldapconn;
    $loginName = "";
    //echo "<div class='table'>";
    foreach ($results as $key => $value) {
        if (is_array($value)) {
            $accountName = $value["samaccountname"][0];
            //echo "<div class='row'>";
            //echo "<div class='cell'>[$accountName]</div>";
            //echo "<div class='cell'>[$username]</div>";
            //echo "</div>";
            if (strcasecmp($accountName, $username) == 0) {
                $loginName = $value["dn"];
                echo "<h3>Found User: " . getName($loginName) . "</h3>";
                break;
            }
        }
        //echo "</div>";
    }
    if ($loginName != "") {
        //$dn = "CN=" . $loginName . "," . $dn;
        if (@ldap_bind($ldapconn, $loginName, $password)) {
            echo "<h3>User Authenticated :D</h3>";
        } else echo "<h3>Bind for [$loginName] Failed :(</h3>";
    }
}
function myPrint($results, $attributes, $username) {
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
            $selected = strcasecmp($accountName, $username) == 0 ? "selected" : "";
            $image = base64_encode($value["jpegphoto"][0]);
            //echo "<img src='data:image/jpeg;base64,$image'/>";
            echo "<div class='row " . $selected . "' data-img-src='data:image/jpeg;base64,$image'>";
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
function prettyPrint($results, $a, $b) {
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