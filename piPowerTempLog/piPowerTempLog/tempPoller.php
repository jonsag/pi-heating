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
$html = file($tempUrl);

///// how many lines in this file
$numLines = count($html);

if ($debug) {
  echo "Webpage " . $url . "<br>\nconsists of " . $numLines . " lines";
  lf();
  echo "-----------------------------------------------------";
  lf();
}

// connect to MySQL                                                                  
if (!$db_con) {
  die('Could not connect: ' . mysqli_error());
}

// select database                                                                   
mysqli_select_db($db_name);

$sql = "SELECT COUNT(*) FROM 1wireDevices WHERE deviceType='temp'";

$query = mysqli_query($sql);

$result = mysqli_fetch_row($query);

if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

$numberOfTemps = $result[0];

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

  ///// find temp values
  for ($s = 0; $s <= $numberOfTemps - 1; $s++) {
    if (preg_match('/(' . $tempTempValueMatch . '' . $s . ': )(.*)/', $line)) {
      preg_match('/(' . $tempTempValueMatch . '' . $s . ': )(.*)/', $line, $matches);
      $tempValue[$s] = $matches[2];
      $tempValue[$s] = substr($tempValue[$s], 0, -6);
      $tempValue[$s] = substr($tempValue[$s],0,strrpos($tempValue[$s],'C'));
      $tempValue[$s] = str_replace(' ', '', $tempValue[$s]);
    }
  }
}

if ($debug) {
  echo "-----------------------------------------------------";
  lf();
}

echo "This servers time stamp: " . $thisTime;
lf();

for ($s = 0; $s <= $numberOfTemps; $s++) {
  if ($tempValue[$s] != "") {
    echo "temp" . $s . ": " . $tempValue[$s];
    lf();
  }
}

if ($event != "") {
  echo "event: " . $event;
  lf();
}

if ($poll) {
  
  echo "Writing to MySQL...";
  lf();
  
  $sql = "INSERT INTO tempLog (temp0, temp1, temp2, temp3, temp4, temp5, temp6, temp7, temp8, temp9, temp10, event)
   VALUES (
   '$tempValue[0]',
   '$tempValue[1]',
   '$tempValue[2]',
   '$tempValue[3]',
   '$tempValue[4]',
   '$tempValue[5]',
   '$tempValue[6]',
   '$tempValue[7]',
   '$tempValue[8]',
   '$tempValue[9]',
   '$tempValue[10]', 
   '$event')";
  
  $result = mysqli_query($sql);
  
  if ($result) {
    echo "OK";
    lf();
    echo "Resetting after poll";
    lf();
    file($tempPollReset);      
  }
  else {
    die('Invalid query: ' . mysqli_error());
  }
  
  mysqli_close($db_con);
}
?>
