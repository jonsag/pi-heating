<?php

    $powerIP = "192.168.10.10";
    //$tempIP = "localhost";
    $weatherIP ="localhost";

    // arduino logging the currents
    $powerUrl = 'http://' . $powerIP;
    $powerPollReset = 'http://' . $powerIP . '/?pollReset';
    
    // NA
    //$tempUrl = 'http://' . $tempIP . '/jsPowerTempLog/temperature.php';
    //$tempPollReset = 'http://' . $tempIP . '/jsPowerTempLog/tempPollReset.php';
    
    // raspberry hosting the weather arduino
    $weatherUrl = 'http://' . $weatherIP . ':8083/weather.php';
    $weatherPollReset = 'http://' . $weatherIP . ':8083/weather.php?poll=1';

    date_default_timezone_set('Europe/Stockholm');
    //setlocale(LC_ALL, 'en_US');
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $ini_array = parse_ini_file("/home/pi/piHeatingHub/config/config.ini", true);
    
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
    //$tempTempValueMatch = "Temperature sensor ";
    
    
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
