<?php
//lock to mario IP

/*
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !in_array(@$_SERVER['REMOTE_ADDR'], array('173.255.196.108','66.228.52.201','96.126.121.86','198.58.113.40','72.14.181.19','96.126.121.87','96.126.121.84', '173.255.197.91','198.58.103.85','96.126.121.85','99.91.1.31','70.113.29.186', '127.0.0.1', 'fe80::1','::1','66.90.226.4'))
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Email mariochampion@trails.by for more info.');
}
*/
//make debugging easier
ini_set('display_errors', 'On');
error_reporting(E_ALL);

?>