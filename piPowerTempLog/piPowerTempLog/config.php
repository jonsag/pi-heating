<?php

date_default_timezone_set('Europe/Stockholm');
//setlocale(LC_ALL, 'en_US');

// Connections Parameters
$db_host = "localhost";
$db_name = "arduino1";
$username = "arduino";
$password = "arduinopass";
$db_con = mysql_connect($db_host,$username,$password);
$connection_string = mysql_select_db($db_name);
// Connection
//mysql_connect($db_host,$username,$password);
//mysql_select_db($db_name);

$url = 'http://arduino1';
$pollReset = 'http://arduino1/?pollReset';

$currentTimeMatch = "Current time: ";
// $lastSyncMatch = "";
// $skewMatch = "";
$unixTimeMatch = "Unix time: ";
// $loopTimeMatch = "";
$currentValueMatch = "Current phase ";
$currentAverageValueMatch = "Current average phase ";
$tempValueMatch = "Temperature sensor ";
$pulsesLastIntervalMatch = "Pulses last interval: ";
$pulsesMatch = "Pulses since last poll: ";
?>
