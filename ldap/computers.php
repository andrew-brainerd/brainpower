<?php
/**
 * Created by PhpStorm.
 * User: abrainerd
 * Date: 11/30/2016
 * Time: 11:49 AM
 */

if (!session_id()) {
    @session_start();
}
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
$baseDN = "DC=thedomain,DC=umcu,DC=org";
$attributes = array(
    "distinguishedName",
    "samaccountname",
    //"lastlogontimestamp",
    "lockouttime",
    //"badpasswordtime",
    //"badpwdcount"
);

if ($ldapconn) {
    $ldapbind = @ldap_bind($ldapconn, "CN=SU,OU=Administrators," . $baseDN, "C3t1@lph@V!$");
    if ($ldapbind) {
        $dn = $location . "," . $baseDN;
        //echo "<h3>Searching in: $dn</h3>";
        $filter = "(objectClass=computer)";
        $ldapresults = ldap_search($ldapconn, $dn, $filter, $attributes);
        if (!$ldapresults) die("Search Failed");
        //if (1 > ldap_count_entries($ldapconn, $ldapresults)) echo "<br /><h3>No Locked Users in $location</h3>";
        else {
            //echo "<h3>Locked users in $location: " . ldap_count_entries($ldapconn, $ldapresults) . "</h3>";
            $results = ldap_get_entries($ldapconn, $ldapresults);
            ldap_free_result($ldapresults);
        }
    } else die("<h3>User Login Failed [" . ldap_error($ldapconn) . "]</h3>");
} else die("Failed to connect to Active Directory");
ldap_unbind($ldapconn);
prettyPrint($results, $attributes);
function prettyPrint($results, $a) {
    print "<pre>";
    print_r($results);
    print "</pre>";
}