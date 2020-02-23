<?php

    date_default_timezone_set('Europe/Stockholm');
    //setlocale(LC_ALL, 'en_US');
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);    
    
    
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



