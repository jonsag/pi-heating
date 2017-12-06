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
$html = file($weatherUrl);

///// how many lines in this file
$numLines = count($html);

if ($debug) {
  echo "Webpage " . $weatherUrl . "<br>\nconsists of " . $numLines . " lines";
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

  ///// find wind direction
  if (preg_match('/(' . $weatherWindDirMatch . ')(.*)/', $line)) {
    preg_match('/(' . $weatherWindDirMatch . ')(.*)/', $line, $matches);
    $windDirection = str_replace('<br>', '', $matches[2]);
  }

  ///// find wind direction degrees
  if (preg_match('/(' . $weatherWindDirDegMatch . ')(.*)/', $line)) {
    preg_match('/(' . $weatherWindDirDegMatch . ')(.*)/', $line, $matches);
    $windDirectionValue = str_replace('<br>', '', $matches[2]);
  }

  ///// find average wind direction degrees
  if (preg_match('/(' . $weatherAvgWindDirDegMatch . ')(.*)/', $line)) {
    preg_match('/(' . $weatherAvgWindDirDegMatch . ')(.*)/', $line, $matches);
    $averageWindDirectionValue = str_replace('<br>', '', $matches[2]);
  }

  ///// find wind speed
  if (preg_match('/(' . $weatherWindSpeedMatch . ')(.*)/', $line)) {
    preg_match('/(' . $weatherWindSpeedMatch . ')(.*)/', $line, $matches);
    $windSpeed = str_replace('<br>', '', $matches[2]);
  }

  ///// find average wind speed
  if (preg_match('/(' . $weatherAverageWindSpeedMatch . ')(.*)/', $line)) {
    preg_match('/(' . $weatherAverageWindSpeedMatch . ')(.*)/', $line, $matches);
    $averageWindSpeed = str_replace('<br>', '', $matches[2]);
  }


  ///// find rain since last poll
  if (preg_match('/(' . $weatherRainSinceLastMatch . ')(.*)/', $line)) {
    preg_match('/(' . $weatherRainSinceLastMatch . ')(.*)/', $line, $matches);
    $rainSinceLast = str_replace('<br>', '', $matches[2]);
  }

}

if ($debug) {
  echo "-----------------------------------------------------";
  lf();
}

echo "This servers time stamp: " . $thisTime;
lf();

if ($windDirection != "") {
  echo "windDirection :" . $windDirection;
  lf();
}

if ($windDirectionValue != "") {
  echo "windDirValue: " . $windDirectionValue;
  lf();
}

  if ($averageWindDirectionValue != "") {
    echo "avgWindDirValue: " . $averageWindDirectionValue;
    lf();
  }

if ($windSpeed != "") {
  echo "windSpeed: " . $windSpeed;
  lf();
}

if ($averageWindSpeed != "") {
  echo "averageWindSpeed: " . $averageWindSpeed;
  lf();
}

if ($rainSinceLast != "") {
  echo "rainSinceLast: " . $rainSinceLast;
  lf();
}


if ($event != "") {
  echo "event: " . $event;
  lf();
}


if ($poll) {

  // connect to MySQL
  if (!$db_con) {
    die('Could not connect: ' . mysql_error());
  }

  // select database
  mysql_select_db($db_name);
  
  echo "Writing to MySQL...";
  lf();
  
  $sql = "INSERT INTO weatherLog (ts, windDirection, windDirectionValue, averageWindDirectionValue, windSpeed, averageWindSpeed, rainSinceLast, event)
   VALUES (
   '$thisTime',
   '$windDirection',
   '$windDirectionValue',
   '$averageWindDirectionValue',
   '$windSpeed',
   '$averageWindSpeed',
   '$rainSinceLast',
   '$event')";
  
  $result = mysql_query($sql);
  
  if ($result) {
    echo "OK";
    lf();

    // reset values
    echo "Resetting after poll";
    lf();
    if($debug) {
      $html = file($weatherPollReset . "&debug=1");
    }
    else {
      $html = file($weatherPollReset);
    }

    $numLines = count($html);

    if ($debug) {
      echo "Webpage " . $weatherPollReset . "<br>\nconsists of " . $numLines . " lines";
      lf();
      echo "-----------------------------------------------------";
      lf();

      ///// process each line
      for ($i = 0; $i < $numLines; $i++) {
	// use trim to remove the carriage return and/or line feed character at the end of line
	$line = trim($html[$i]);
	///// show webpage with line numbers
	if ($debug) {
	  echo "#" . $i . " . " . $line . "";
	  lf();
	}
      } 

    }
  }
  else {
    die('Invalid query: ' . mysql_error());
  }
  
  mysql_close($db_con);
}
  
?>
