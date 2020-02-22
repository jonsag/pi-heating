<?php

date_default_timezone_set('Europe/Stockholm');
//setlocale(LC_ALL, 'en_US');

// Connections Parameters
$db_host = "localhost";
$db_name = "powerTempLog";
$username = "arduino";
$password = "arduinopass";

$db_con = mysqli_connect($db_host,$username,$password);
$connection_string = mysqli_select_db($db_name);

// Connection
//mysqli_connect($db_host,$username,$password);
//mysqli_select_db($db_name);

$powerUrl = 'http://arduino01';
$powerPollReset = 'http://arduino01/?pollReset';

$tempUrl = 'http://localhost/jsPowerTempLog/temperature.php';
$tempPollReset = 'http://localhost/jsPowerTempLog/tempPollReset.php';

$weatherUrl = 'http://localhost/jsPowerTempLog/weather.php';
$weatherPollReset = 'http://localhost/jsPowerTempLog/weather.php?poll=1';

// power poller
$powerCurrentTimeMatch = "Current time: ";
// $lastSyncMatch = "";
// $skewMatch = "";
$powerUnixTimeMatch = "Unix time: ";
// $loopTimeMatch = "";
$powerCurrentValueMatch = "Current phase ";
$powerCurrentAverageValueMatch = "Current average phase ";
$powerTempValueMatch = "Temperature sensor ";
$powerPulsesLastIntervalMatch = "Pulses last interval: ";
$powerPulsesMatch = "Pulses since last poll: ";

// temp poller
$tempTempValueMatch = "Temperature sensor ";

// weather poller
$weatherPollStartMatch = "pollStart";
$weatherPollEndMatch = "pollEnd";

$weatherWindDirMatch = "Wind direction: ";
$weatherWindDirDegMatch = "Wind direction degrees: ";
$weatherAvgWindDirDegMatch = "Average wind direction degrees: ";
$weatherWindSpeedMatch = "Wind speed: ";
$weatherAverageWindSpeedMatch = "Average wind speed: ";
$weatherRainSinceLastMatch = "Rain since last poll: ";

?>
