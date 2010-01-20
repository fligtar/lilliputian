<?php
/**
 * Redirector
 * This file handles all incoming URL keys, increments the counter, and forwards
 * along to the destination if it exists
 */
require 'init.php';

$key = mysql_real_escape_string(str_replace($path.'/', '', $_SERVER['REQUEST_URI']));

// key is a MySQL reserved word
$qry = mysql_query("SELECT * FROM lilliputian WHERE `key` = '{$key}' LIMIT 1");

$result = mysql_fetch_array($qry);

if ($result) {
    // We found a key. Let's increment the counter and redirect!
    mysql_query("UPDATE lilliputian SET hits = hits + 1 WHERE `key` = '{$key}'");
    
    header('Location: '.$result['url']);
    exit;
}
else {
    // No such key
    die('Bad URL! Bad!');
}

?>