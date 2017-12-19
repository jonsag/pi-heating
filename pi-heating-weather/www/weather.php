<html>
<head>
<title>JS Weather Station</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<body>
<h1><center>JS Weather Station</center></h1>
<center>- part of jsPowerTempLog</center>
<br>

<?php
    include ('config.php');
    include ('functions/functions.php');
    include "classes/php_serial.class.php";
    
    if($_GET['poll']) {
      $poll = "true";
    }
    
    if($_GET['debug']) {
      $debug = "true";
    }
    
    $counter1 = 0;
    $counter2 = 0;
    $startOK = 0;
    $endOK = 0;
    
    define("PORT","/dev/ttyAMC0");
    $serial = new phpSerial;
    $serial->deviceSet(PORT);
    $serial->confBaudRate(9600);
    $serial->confParity("none");
    $serial->confCharacterLength(8);
    $serial->confStopBits(1);
    $serial->confFlowControl("none");
    
    // open serial
    $serial->deviceOpen();
    
    if ($debug == "true" || $poll != "true" ) {
    
      $string1 = array("pollStart", "Wind direction", "Wind direction degrees", "Average wind direction degrees", "Wind speed", "Average wind speed", "Rain since last poll", "pollEnd");
      
      // write p to serial
      $serial->sendMessage("p");
      
      // read answer
      $read = $serial->readPort();
      
      $string2 = explode(",", $read);
      
      for ($counter1; $counter1 <= 6; $counter1++) {
        if ($string2[$counter1] == $weatherPollStartMatch) { 
          $startOK = 1;
          dlf();
        }
        else if (substr($string2[$counter1], 0, 7) == $weatherPollEndMatch) {
          $endOK = 1;
          dlf();
        }
        else {
          echo $string1[$counter1] . ": " . $string2[$counter1];
          lf();
        }
      }
      
      lf();
      
      if ($startOK == 1 && $endOK == 1) {
        echo "OK";
        lf();
        echo "Recieved full message";
      }
      else {
        echo "Error";
        lf();
        echo "Recieved incomplete message";
      }
      dlf();
    }
    
    if ($poll == "true") {
      echo "Resetting values...";
      lf();
      // write r to serial
      $serial->sendMessage("r");
      // read answer
      $read = $serial->readPort();
    
      $string3 = array("Values", "reset");
      $string4 = explode(" ", $read);
      if($string3[0] == substr($string4[0], 0, 6) && $string3[1] == substr($string4[1], 0, 5)) {
        echo "Reset OK";
      }
      else {
        echo "Failed to reset";
      }
    
    }
    
    // close device
    $serial->deviceClose();

?>

</body>
</html>
