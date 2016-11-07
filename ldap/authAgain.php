/**
* This gist expects the following parameters
*
* @param string $host The LDAP-Host
* @param int    $port The LDAP-Port
* @param string|null $rdnUsername The DN of a user with read-credentials to the LDAP. Not necessary for anonymous bind.
* @param string|null $rdnPassword THe password of the $rdnUsername
* @param string|null $filter THe filter to be used to find the user in the LDAP
*/
$_connect = ldap_connect($host);
if (! $_connect) {
die 'no connection';
}
if (isset($rdnUsername) && isset($rdnPassword)) {
// BEGIN IF.
$args [] = $rdnUsername;
$args [] = $rdnPassword;
}
if ( ! call_user_func_array ( 'ldap_bind', $args ) ) {
// Binding to the LDAP Server for querying the LDAP failed.
// This can be one of many reasons.
die sprintf(
'Could not bind to server %s. Returned Error was: [%s] %s',
$host,
ldap_errno($_connect),
ldap_error($_connect)
);
}
// Binding was successfull, so lets get some information from the
// LDAP about the user.
// This information includes the DN, so that we can finaly try to
// bind to the LDAP with that DN and the provided password.
if (! isset($filter)) {
$filter = '(&(uid=%s)(objectClass=posixAccount))';
}
// Remove all non-permitted Characters from the username.
// Currently only Usernames containing ASCII-Characters, numbers,
// @-sign, full stop (.), minus (-) and underscore (_) are permitted.
$trimmerdUsername = trim(preg_replace('/[^a-zA-Z0-9\-\_@\.]/', '', $options['username']));
$filter           = str_replace('%s', $trimmerdUsername, $filter);
$_ldapresults = ldap_search($_connect, $baseDN, $filter, array('uid'), 0, 0, 10 );
if (! $_ldapresults) {
// The server returned no result-set.
die 'No user with that informations found';
}
if (1 > ldap_count_entries($_connect, $_ldapresults)) {
// The returned result set contains no data.
die 'No user with that information found';
}
if (1 < ldap_count_entries($_connect, $_ldapresults ) > 1 ) {
// The returned result-set contains more than one person. So we
// can not be sure, that the user is unique.
die 'More than one user found with that information';
}
$_results = ldap_get_entries($_connect, $_ldapresults);
if (false === $_results) {
// The returned result-set could not be retrieved.
die 'no result set found';
}
// Empty the result set. We have the results in a variable so don't
// bother the server any more.
ldap_free_result ( $_ldapresults );
$distinguishedName = $_results[0]['dn'];
// Now lets try to bind with the returned distinguishedName and the
// provided passwort to the LDAP.
$link_id = @ldap_bind($_connect, $distinguishedName, $password);
if (false === $link_id) {
die 'BIND failed';
}
