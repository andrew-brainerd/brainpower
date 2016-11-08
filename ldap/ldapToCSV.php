<?php
//define(LDAP_OPT_DIAGNOSTIC_MESSAGE, 0x0032);
//echo "<h1>Current User: " . $_SERVER['AUTH_USER'] . "</h1>";
$username = $_GET["username"];
$password = $_GET["password"];
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=UMCU_Active_Directory_Users.csv");
$output = fopen("php://output", "w");
fputcsv($output, array("Organizational Unit", "User", "Account Name", "Email", "Last Logon"));

if ($ldapconn) {
    $dn = "DC=thedomain,DC=umcu,DC=org";
    $ldapbind = @ldap_bind($ldapconn, "CN=Andrew Brainerd,CN=Users," . $dn, "b0ggl3sth3m!nd");
    if ($ldapbind) {
        //echo "<h5>User Verified via Active Directory</h5>";
        $dn = "OU=All Staff,DC=thedomain,DC=umcu,DC=org";
        $filter = "(&(objectClass=user))";
        $attributes = array(
            "distinguishedName",
            "mail",
            "samaccountname",
            "lastLogonTimestamp"
        );
        $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
        if (!$ldapresults) echo "<br />Super Search Fail"; //else echo "<br />Performed a search";
        if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo "<br />No users with that information found";
        else {
            $results = ldap_get_entries($ldapconn, $ldapresults);
            ldap_free_result($ldapresults);
            //if ($results["count"] > 1) echo "<br />" . $results["count"] . " records found";
            //if (false === $results) echo "no result set found";
            foreach ($results as $key => $value) {
                if (is_array($value)) {
                    $lastLogonTime = date("m-d-Y h:i", $value["lastlogontimestamp"][0] / 10000000 - 11644473600);
                    $row = array(getGroup($value["dn"]), getName($value["dn"]), $value["samaccountname"][0], $value["mail"][0], $lastLogonTime);
                    fputcsv($output, $row);
                }
            }
        }
    } else echo "<h3>User Login Failed [" . ldap_error($ldapconn) . "]</h3>";
} else echo "Failed to connect to Active Directory";

function myPrint($results)
{
}

function prettyPrint($results)
{
    print "<pre>";
    print_r($results);
    print "</pre>";
}

function getName($dn)
{
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

function getGroup($dn)
{
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

function out($msg)
{
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