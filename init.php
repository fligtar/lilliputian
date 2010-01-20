<?php
/**
 * This file checks the config file and connects to the database.
 */

if (!file_exists('config.php')) {
    die('Configuration file missing. Please copy config.php.default to config.php and fill in the values.');
}

require 'config.php';

$db = mysql_connect($db_host, $db_user, $db_pass) or die ('Could not connect to database');
mysql_select_db($db_name) or die('Could not select database');

// Get the local path to this directory without a trailing slash
$path = dirname($_SERVER['PHP_SELF']);
$path = ($path == '/') ? '' : $path;

?>