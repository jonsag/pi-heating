<html>
<head>
<title>piWeatherLog</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<body>
<div style="text-align:center">
<h1>piWeatherLog</h1>
- part of piHeating -
</div>
<br>

<?php
    include ('config.php');
    include ('functions/functions.php');
    require ('classes/php_serial.class.php');
    
    if(isset($_GET['poll'])) {
        $poll = "true";
    } else {
        $poll = "false";
    }
    
    if(isset($_GET['debug'])) {
        $debug = "true";
    } else {
        $debug = "false";
    }
    
    $counter1 = 0;
    $counter2 = 0;
    $startOK = 0;
    $endOK = 0;
    
    //define("PORT","/dev/ttyACM0");
    $serial = new phpSerial;
    //$serial->deviceSet(PORT);
    $serial->deviceSet("/dev/ttyACM0");
    $serial->confBaudRate(9600);
    $serial->confParity("none");
    $serial->confCharacterLength(8);
    $serial->confStopBits(1);
    //$serial->confFlowControl("none");
    
    // open serial
    $serial->deviceOpen();
    
    if ($debug == "true" || $poll != "true" ) {
    
      $string1 = array("pollStart", "Wind direction", "Wind direction degrees", "Average wind direction degrees", "Wind speed", "Average wind speed", "Rain since last poll", "pollEnd");
      
      // write p to serial
      $serial->sendMessage("p");
      
      // read answer
      $read = $serial->readPort();
      
      //echo $read;
      
      $string2 = explode(",", $read);
      
      //foreach ($string2 as $row) {
      //    lf();
      //    echo "'" . $row . "'";
      //}
      
      for ($counter1; $counter1 <= 7; $counter1++) {
          //echo $counter1 . ": " . $string2[$counter1];
          //lf();
        if ($string2[$counter1] == $weatherPollStartMatch) { 
          $startOK = 1;
          //echo "Start OK";
          dlf();
        }
        //else if ($string2[$counter1] == $weatherPollEndMatch) {
        else if (substr($string2[$counter1], 0, 7) == $weatherPollEndMatch) {
          $endOK = 1;
          //echo "End OK";
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
