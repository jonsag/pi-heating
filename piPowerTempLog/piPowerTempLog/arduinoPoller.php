<?php

///// turn off error reporting
error_reporting (E_ALL ^ E_NOTICE);

///// include configuration file
include ('config.php');

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
$html = file($url);

///// how many lines in this file
$numLines = count($html);

if ($debug) {
  echo "Webpage " . $url . "<br>\nconsists of " . $numLines . " lines<br>\n";
  echo "-----------------------------------------------------<br>\n";
}

///// process each line
for ($i = 0; $i < $numLines; $i++) {
  // use trim to remove the carriage return and/or line feed character
  // at the end of line
  $line = trim($html[$i]);
  
  ///// show webpage with line numbers 
  if ($debug) {
    echo "#" . $i . " . " . $line . "";
  }
  
  ///// find currentTime
  if (preg_match('/(' . $currentTimeMatch . ')(.*)/', $line)) {
    preg_match('/(' . $currentTimeMatch . ')(.*)/', $line, $matches);
    $currentTime = $matches[2];
    $currentTime = substr($currentTime, 0, -10);
  }
  
  ///// find lastSync
  //if (preg_match('/(' . $lastSyncMatch . ')(.*)/', $line)) {
  //   preg_match('/(' . $lastSyncMatch . ')(.*)/', $line, $matches);
  //   $lastSync = $matches[2];
  //   $lastSync = substr($lastSync, 0, -10);
  //}
  
  ///// find skew
  //if (preg_match('/(' . $skewMatch . ')(.*)/', $line)) {
  //   preg_match('/(' . $skewMatch . ')(.*)/', $line, $matches);
  //   $skew = $matches[2];
  //   $skew = substr($skew, 0, -12);
  //}
  
  ///// find unixTime
  if (preg_match('/(' . $unixTimeMatch . ')(.*)/', $line)) {
    preg_match('/(' . $unixTimeMatch . ')(.*)/', $line, $matches);
    $unixTime = $matches[2];
    $unixTime = substr($unixTime, 0, -4);
  }
  
  ///// find loopTime
  //if (preg_match('/(' . $loopTimeMatch . ')(.*)/', $line)) {
  //   preg_match('/(' . $loopTimeMatch . ')(.*)/', $line, $matches);
  //   $loopTime = $matches[2];
  //   $loopTime = substr($loopTime, 0, -7);
  //}
  
  ///// find currentValue
  for ($s = 1; $s <= 3; $s++) {
    if (preg_match('/(' . $currentValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $currentValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $currentValue[$s] = $matches[2];
      $currentValue[$s] = substr($currentValue[$s], 0, -6);
    }
  }

  ///// find currentAverageValue
  for ($s = 1; $s <= 3; $s++) {
    if (preg_match('/(' . $currentAverageValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $currentAverageValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $currentAverageValue[$s] = $matches[2];
      $currentAverageValue[$s] = substr($currentAverageValue[$s], 0, -6);
    }
  }


  ///// find tempValue
  for ($s = 0; $s <= 5; $s++) {
    if (preg_match('/(' . $tempValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $tempValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $tempValue[$s] = $matches[2];
      $tempValue[$s] = substr($tempValue[$s], 0, -6);
    }
  }
  
  ///// find pulsesSinceStart
  //  if (preg_match('/(' . $pulsesSinceStartMatch . ')(.*)/', $line)) {
  //  preg_match('/(' . $pulsesSinceStartMatch . ')(.*)/', $line, $matches);
  //  $pulsesSinceStart = $matches[2];
  //  $pulsesSinceStart = substr($pulsesSinceStart, 0, -4);
  //}
  
  ///// find pulses
  //  if (preg_match('/(' . $pulsesLastIntervalMatch . ')(.*)/', $line)) {
  //  preg_match('/(' . $pulsesLastIntervalMatch . ')(.*)/', $line, $matches);
  //  $pulsesLastInterval = $matches[2];
  //  $pulsesLastInterval = substr($pulsesLastInterval, 0, -4);
  //}
  
  ///// find pulses
  if (preg_match('/(' . $pulsesMatch . ')(.*)/', $line)) {
    preg_match('/(' . $pulsesMatch . ')(.*)/', $line, $matches);
    $pulses = $matches[2];
    $pulses = substr($pulses, 0, -4);
  }
  
  
}

if ($debug) {
  echo "-----------------------------------------------------<br>\n";
}

echo "This servers time stamp: " . $thisTime . "<br>\n";

echo "Arduinos currentTime: " . $currentTime . "<br>\n";

$timeDiff = abs(strtotime($currentTime) - strtotime($thisTime));
echo "Time difference: " . $timeDiff . "<br>\n";

//echo "lastSync: " . $lastSync . "<br>\n";
//echo "skew: " . $skew . "-<br>\n"";

echo "Arduinos unixTime: " . $unixTime . "<br>\n";

//echo "loopTime: " . $loopTime . "<br>\n";

for ($s = 1; $s <= 3; $s++) {
  if ($currentValue[$s] != "") {
    echo "currentValue" . $s . ": " . $currentValue[$s] . "<br>\n";
  }
}

for ($s = 1; $s <= 3; $s++) {
  if ($currentAverageValue[$s] != "") {
    echo "currentAverageValue" . $s . ": " . $currentAverageValue[$s] . "<br>\n";
  }
}


for ($s = 0; $s <= 5; $s++) {
  if ($tempValue[$s] != "") {
    echo "tempValue" . $s . ": " . $tempValue[$s] . "<br>\n";
  }
}


//echo "pulsesSinceStart: " . $pulsesSinceStart . "<br>\n";
//echo "pulsesLastInterval: " . $pulsesLastInterval . "<br>\n";
echo "pulses: " . $pulses . "<br>\n";

if ($event != "") {
  echo "event: " . $event . "<br>\n";
}

if ($poll) {
  
  echo "Polling MySQL...<br>\n";
  
  if (!$db_con) {
    die('Could not connect: ' . mysql_error());
  }
  
  mysql_select_db($db_name);
  
  $query = "INSERT INTO pulseLog (currentTime, timeDiff, unixTime, currentR1, currentS2, currentT3, currentAverageR1, currentAverageS2, currentAverageT3, temp0, temp1, temp2, temp3, temp4, temp5,  pulses, event)
   VALUES (
   '$currentTime',
   '$timeDiff',
   '$unixTime',
   '$currentValue[1]',
   '$currentValue[2]',
   '$currentValue[3]',
   '$currentAverageValue[1]',
   '$currentAverageValue[2]',
   '$currentAverageValue[3]',
   '$tempValue[0]',
   '$tempValue[1]',
   '$tempValue[2]',
   '$tempValue[3]',
   '$tempValue[4]',
   '$tempValue[5]',
   '$pulses',
   '$event')";
  
  $result = mysql_query($query);
  
  if ($result) {
    echo "OK<br>\n";
    echo "Resetting pulses<br>\n";
    file($pollReset);      
  }
  else {
    die('Invalid query: ' . mysql_error());
  }
  
  mysql_close($db_con);
}
?>
