<?php
/**
 * Redirector
 * This file handles all incoming URL keys, increments the counter, and forwards
 * along to the destination if it exists
 */

if (!file_exists('config.php')) {
    die('Configuration file missing. Please copy config.php.default to config.php and fill in the values.');
}

require 'config.php';

$db = mysql_connect($db_host, $db_user, $db_pass) or die ('Could not connect to database');
mysql_select_db($db_name) or die('Could not select database');

$path = dirname($_SERVER['PHP_SELF']);
$key = mysql_real_escape_string(str_replace($path.'/', '', $_SERVER['REQUEST_URI']));

// key is a MySQL reserved word
$qry = mysql_query("SELECT * FROM lilliputian WHERE `key` = '{$key}' LIMIT 1");

$result = mysql_fetch_array($qry);

if ($result) {
    mysql_query("UPDATE lilliputian SET hits = hits + 1 WHERE `key` = '{$key}'");
    
    header('Location: '.$result['url']);
    exit;
}
else {
    die('Bad URL! Bad!');
}

?>