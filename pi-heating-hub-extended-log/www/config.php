<?php

    date_default_timezone_set('Europe/Stockholm');
    //setlocale(LC_ALL, 'en_US');
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $ini_array = parse_ini_file("/home/pi/pi-heating-hub/config/config.ini", true);
    
    $servername = $ini_array['db']['server'];
    $username =$ini_array['db']['user'];
    $password = $ini_array['db']['password'];
    $dbname = $ini_array['db']['database'];
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $powerUrl = 'http://192.168.10.10';
    $powerPollReset = 'http://192.168.10.10/?pollReset';
    
    $tempUrl = 'http://localhost/jsPowerTempLog/temperature.php';
    $tempPollReset = 'http://localhost/jsPowerTempLog/tempPollReset.php';
    
    $weatherUrl = 'http://localhost/pi-heating-weather/weather.php';
    $weatherPollReset = 'http://localhost/pi-heating-weather/weather.php?poll=1';
    
    
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
