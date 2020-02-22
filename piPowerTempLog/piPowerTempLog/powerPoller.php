<?php

///// turn off error reporting
error_reporting (E_ALL ^ E_NOTICE);

///// include configuration file
include ('config.php');
include ('functions/functions.php');

///// debug argument
if ($argv[1] == "") {
  $debug = 0;
}
else {
  $debug = $argv[1];
}

if ($_GET['debug']) {
  $debug = 1;
}

///// poll argument
if ($argv[2] == "") {
  $poll = 0;
}
else {
  $poll = $argv[2];
}

if ($_GET['poll']) {
  $poll = 1;
}

///// event argument
if ($_GET['event'] != "") {
  $event = $_GET['event'];
}

if ($argv[3] != "") {
  $event = $argv[3];
}

$thisTime =  date('Y\-m\-d\ H\:i\:s');

///// get web page
//$html = file_get_contents($url);
$html = file($powerUrl);

///// how many lines in this file
$numLines = count($html);

if ($debug) {
  echo "Webpage " . $url . "<br>\nconsists of " . $numLines . " lines";
  lf();
  echo "-----------------------------------------------------";
  lf();
}

///// process each line
for ($i = 0; $i < $numLines; $i++) {
  // use trim to remove the carriage return and/or line feed character
  // at the end of line
  $line = trim($html[$i]);
  
  ///// show webpage with line numbers 
  if ($debug) {
    echo "#" . $i . " . " . $line . "";
    lf();
  }
  
  ///// find currentTime
  /*
  if (preg_match('/(' . $powerCurrentTimeMatch . ')(.*)/', $line)) {
    preg_match('/(' . $powerCurrentTimeMatch . ')(.*)/', $line, $matches);
    $currentTime = $matches[2];
    $currentTime = substr($currentTime, 0, -10);
  }
  */

  ///// find lastSync
  /*
  if (preg_match('/(' . $lastSyncMatch . ')(.*)/', $line)) {
     preg_match('/(' . $lastSyncMatch . ')(.*)/', $line, $matches);
     $lastSync = $matches[2];
     $lastSync = substr($lastSync, 0, -10);
  }
  */
  
  ///// find skew
  /*
  if (preg_match('/(' . $skewMatch . ')(.*)/', $line)) {
     preg_match('/(' . $skewMatch . ')(.*)/', $line, $matches);
     $skew = $matches[2];
     $skew = substr($skew, 0, -12);
  }
  */
  
  ///// find unixTime
  /*
  if (preg_match('/(' . $powerUnixTimeMatch . ')(.*)/', $line)) {
    preg_match('/(' . $powerUnixTimeMatch . ')(.*)/', $line, $matches);
    $unixTime = $matches[2];
    $unixTime = substr($unixTime, 0, -4);
  }
  */
  
  ///// find loopTime
  /*
  if (preg_match('/(' . $loopTimeMatch . ')(.*)/', $line)) {
     preg_match('/(' . $loopTimeMatch . ')(.*)/', $line, $matches);
     $loopTime = $matches[2];
     $loopTime = substr($loopTime, 0, -7);
  }
  */
  
  ///// find currentValue
  for ($s = 1; $s <= 3; $s++) {
    if (preg_match('/(' . $powerCurrentValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $powerCurrentValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $currentValue[$s] = $matches[2];
      $currentValue[$s] = substr($currentValue[$s], 0, -6);
    }
  }

  ///// find currentAverageValue
  for ($s = 1; $s <= 3; $s++) {
    if (preg_match('/(' . $powerCurrentAverageValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $powerCurrentAverageValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $currentAverageValue[$s] = $matches[2];
      $currentAverageValue[$s] = substr($currentAverageValue[$s], 0, -6);
    }
  }


  ///// find tempValue
  for ($s = 0; $s <= 5; $s++) {
    if (preg_match('/(' . $powerTempValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $powerTempValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $tempValue[$s] = $matches[2];
      $tempValue[$s] = substr($tempValue[$s], 0, -6);
    }
  }
  
  ///// find pulsesSinceStart
  /*
    if (preg_match('/(' . $pulsesSinceStartMatch . ')(.*)/', $line)) {
    preg_match('/(' . $pulsesSinceStartMatch . ')(.*)/', $line, $matches);
    $pulsesSinceStart = $matches[2];
    $pulsesSinceStart = substr($pulsesSinceStart, 0, -4);
  }
  */
  
  ///// find pulses
  /*
    if (preg_match('/(' . $powerPulsesLastIntervalMatch . ')(.*)/', $line)) {
    preg_match('/(' . $powerPulsesLastIntervalMatch . ')(.*)/', $line, $matches);
    $pulsesLastInterval = $matches[2];
    $pulsesLastInterval = substr($pulsesLastInterval, 0, -4);
  }
  */
  
  ///// find pulses
  if (preg_match('/(' . $powerPulsesMatch . ')(.*)/', $line)) {
    preg_match('/(' . $powerPulsesMatch . ')(.*)/', $line, $matches);
    $pulses = $matches[2];
    $pulses = substr($pulses, 0, -4);
  }
  
  
}

if ($debug) {
  echo "-----------------------------------------------------";
  lf();
}

echo "This servers time stamp: " . $thisTime;
lf();

/*
echo "Arduinos currentTime: " . $currentTime . "<br>\n";

$timeDiff = abs(strtotime($currentTime) - strtotime($thisTime));
echo "Time difference: " . $timeDiff . "<br>\n";

echo "lastSync: " . $lastSync . "<br>\n";
echo "skew: " . $skew . "-<br>\n"";

echo "Arduinos unixTime: " . $unixTime . "<br>\n";

echo "loopTime: " . $loopTime . "<br>\n";
*/

for ($s = 1; $s <= 3; $s++) {
  if ($currentValue[$s] != "") {
    echo "currentValue" . $s . ": " . $currentValue[$s];
    lf();
  }
}

for ($s = 1; $s <= 3; $s++) {
  if ($currentAverageValue[$s] != "") {
    echo "currentAverageValue" . $s . ": " . $currentAverageValue[$s];
    lf();
  }
}


for ($s = 0; $s <= 5; $s++) {
  if ($tempValue[$s] != "") {
    echo "tempValue" . $s . ": " . $tempValue[$s];
    lf();
  }
}


//echo "pulsesSinceStart: " . $pulsesSinceStart . "<br>\n";
//echo "pulsesLastInterval: " . $pulsesLastInterval . "<br>\n";
echo "pulses: " . $pulses;
lf();

if ($event != "") {
  echo "event: " . $event;
  lf();
}

if ($poll) {
  
  echo "Writing to MySQL...";
  lf();
  
  if (!$db_con) {
    die('Could not connect: ' . mysqli_error());
  }
  
  mysqli_select_db($db_con, $db_name);
  
  $sql = "INSERT INTO powerLog (currentR1, currentS2, currentT3, currentAverageR1, currentAverageS2, currentAverageT3, temp, pulses, event)
   VALUES (
   '$currentValue[1]',
   '$currentValue[2]',
   '$currentValue[3]',
   '$currentAverageValue[1]',
   '$currentAverageValue[2]',
   '$currentAverageValue[3]',
   '$tempValue[0]',
   '$pulses',
   '$event')";
  
  $result = mysqli_query($sql);
  
  if ($result) {
    echo "OK";
    lf();
    echo "Resetting pulses";
    lf();
    file($powerPollReset);      
  }
  else {
      die('Invalid query: ' . mysqli_error($db_con));
  }
  
  mysqli_close($db_con);
}
?>
