<?php
$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
$ldaptree = "OU=Information Technology,OU=All Staff,DC=thedomain,DC=umcu,DC=org";
if ($ldapconn) {
    $ldapbind = ldap_bind($ldapconn);
    if ($ldapbind) {
        //echo "<h5>Connected to Active Directory :D</h5>";
        //$result = ldap_search($ldapconn, $ldaptree, "(CN=*)") or die ("Error in search query: " . ldap_error($ldapconn));
    } else echo "<h3>I'm fine, just can't do LDAP apparently</h3>";
}
?>