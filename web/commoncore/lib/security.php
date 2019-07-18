<?php
//lock to restricted IPs

/*
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('add.authed.IPs.here.'))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Email mariochampion@trails.by for more info.');
}
*/
//make debugging easier
ini_set('display_errors', 'On');
error_reporting(E_ALL);

?>
