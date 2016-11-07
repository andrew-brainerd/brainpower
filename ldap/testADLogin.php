<?php
//define(LDAP_OPT_DIAGNOSTIC_MESSAGE, 0x0032);
$username = $_GET["username"];
$password = $_GET["password"];
//ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
//ldap_set_option(NULL, LDAP_OPT_TIMELIMIT, 4);
//ldap_set_option(NULL, LDAP_OPT_NETWORK_TIMEOUT, 4);
//ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
if ($ldapconn) {
    //$dn = "CN=$username,OU=Information Technology,OU=All Staff,DC=thedomain,DC=umcu,DC=org";
    //$dn = "CN=$username,CN=Users,DC=thedomain,DC=umcu,DC=org";
    $dn = "CN=Users,DC=thedomain,DC=umcu,DC=org";
    $ldapbind = ldap_bind($ldapconn, "CN=$username," . $dn, $password);
    if ($ldapbind) {
        echo "<h3>User Verified via Active Directory</h3>";
        $filter = '(&(uid=%s))'; //(objectClass=posixAccount))';
        $trimmerdUsername = trim(preg_replace('/[^a-zA-Z0-9\-\_@\.]/', '', $username));
        $filter = str_replace('%s', "abrainerd", $filter);
        $filter = "(|(sn=Andrew Brainerd*)(givenname=*))";
        $filter = '(objectClass=*)';
        echo "<br />Trimmed: $trimmerdUsername";
        echo "<br />Filter: $filter";
        $ldapresults = ldap_search($ldapconn, $dn, $filter, array('uid'));
        if (!$ldapresults) echo '<br />No user with that informations found'; else echo "<br />Performed a search :D";
        if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo '<br />No user with that information found';
        if (ldap_count_entries($ldapconn, $ldapresults) > 1) echo '<br />More than one user found with that information';
        $results = ldap_get_entries($ldapconn, $ldapresults);
        if (false === $results) echo 'no result set found';
        ldap_free_result($ldapresults);
        out("Distinguished Name: " . $results[0]["dn"]);
        out("Count: " . $results["count"]);
        print_r($results);
        //$link_id = @ldap_bind($_connect, $distinguishedName, $password);
        //if (false === $link_id) echo 'BIND failed';

    } else echo "<h3>User Login Failed [" . ldap_Error($ldapconn) . "]</h3>";
} else echo "Failed to connect to Active Directory";

function out($msg)
{
    echo "<p>" . $msg . "</p>";
}