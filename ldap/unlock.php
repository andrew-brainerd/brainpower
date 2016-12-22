<?php
if(!session_id()) {
    @session_start();
}
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

$ldapconn = ldap_connect("ldap://umcudc-huron.thedomain.umcu.org");
$baseDN = "DC=thedomain,DC=umcu,DC=org";
$dn = $_POST["dn"];
$device = $_POST["device"];
if ($ldapconn) {
    echo "Got Dist. Name: [$dn]\n";
    $ldapbind = @ldap_bind($ldapconn, "CN=SU,OU=Administrators," . $baseDN, "C3t1@lph@V!$");
    if ($ldapbind) {
        $entries = array();
        $entries["lockouttime"] = 0;
        if (@ldap_modify($ldapconn, $dn, $entries)) {
            $file = "/var/www/html/logs/unlocks";
            $content = file_get_contents($file);
            $content .= "Unlocked " . getName($dn);
            if ($device != " " || $device = "") $content .= " from $device ";
            $content .= " [" . date("m-d-Y H:i") . "]\n";
            file_put_contents($file, $content);
            echo getName($dn) . " is Unlocked :D\n";
        } else {
            echo "Error [" . ldap_errno($ldapconn) . "] " .  ldap_error($ldapconn) . "\n";
        }
    } else echo ldap_error($ldapconn);
} else echo ldap_error($ldapconn);
ldap_unbind($ldapconn);
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