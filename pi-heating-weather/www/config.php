<?php

    date_default_timezone_set('Europe/Stockholm');
    //setlocale(LC_ALL, 'en_US');
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $ini_array = parse_ini_file("/home/pi/pi-heating-weather/config/config.ini", true);
    
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
    
    $weatherUrl = 'http://localhost/pi-heating-weather/weather.php';
    $weatherPollReset = 'http://localhost/pi-heating-weather/weather.php?poll=1';
    
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



