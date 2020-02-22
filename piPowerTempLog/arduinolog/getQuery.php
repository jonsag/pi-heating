<?php

if (!isset($selected)) {
    $selected = false;
  }
  
if (!isset($query)) {
      $query = "start_value";
    }

///// catch attributes
if (isset($_GET['time'])) {
  $timeSelection = $_GET['time'];
}

/////
///// query mysql
/////
///// last number of months, days, hours
if (isset($_GET['years'])) {
  $selected = true;
  $years = $_GET['years'];
  $query = "SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $years YEAR) <= timeStamp";
  $selection = "last_" . $years . "_years";
}

if (isset($_GET['months'])) {
  $selected = true;
  $months = $_GET['months'];
  $query = "SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $months MONTH) <= timeStamp";
  $selection = "last_" . $months . "_months";
}

if (isset($_GET['weeks'])) {
  $selected = true;
  $weeks = $_GET['weeks'];
  $query = "SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $weeks WEEK) <= timeStamp";
  $selection = "last_" . $weeks . "_weeks";
}


if (isset($_GET['days'])) {
  $selected = true;
  $days = $_GET['days'];
  $query = "SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $days DAY) <= timeStamp";
  $selection = "last_" . $days . "_days";
}

if (isset($_GET['hours'])) {
  $selected = true;
  $hours = $_GET['hours'];
  $query = "SELECT * FROM pulseLog WHERE DATE_SUB(NOW(),INTERVAL $hours HOUR) <= timeStamp";
  $selection = "last_" . $hours . "_hours";
}

///// this year month, week, yesterday
if (isset($_GET['this'])) {
  $selected = true;
  if ($_GET['this'] == "year") {
    $query = "SELECT * FROM pulseLog WHERE YEAR(timeStamp) = YEAR(CURDATE())";
    $selection = "this_year";
  }
  if ($_GET['this'] == "month") {
    $query = "SELECT * FROM pulseLog WHERE MONTH(timeStamp) = MONTH(CURDATE())";
    $selection = "this_month";
  }
  if ($_GET['this'] == "week") {
    $query = "SELECT * FROM pulseLog WHERE WEEK(timeStamp) = WEEK(CURDATE())";
    $selection = "this_week";
  }
  if ($_GET['this'] == "day") {
    $query = "SELECT * FROM pulseLog WHERE DATE(timeStamp) = CURDATE()";
    $selection = "today";
  }
}

///// last year month, week, yesterday
if (isset($_GET['last'])) {
  $selected = true;
  if ($_GET['last'] == "year") {
    $query = "SELECT * FROM pulseLog WHERE YEAR(timeStamp) = YEAR(CURDATE()) - 1";
    $selection = "last_year";
  }
  if ($_GET['last'] == "month") {
    $query = "SELECT * FROM pulseLog WHERE MONTH(timeStamp) = MONTH(CURDATE()) - 1";
    $selection = "last_month";
  }
  if ($_GET['last'] == "week") {
    $query = "SELECT * FROM pulseLog WHERE WEEK(timeStamp) = WEEK(CURDATE()) - 1";
    $selection = "last_week";
  }
  if ($_GET['last'] == "day") {
    $query = "SELECT * FROM pulseLog WHERE DATE(timeStamp) = CURDATE() - 1";
    $selection = "yesterday";
  }
}

///// date interval
if (isset($_GET['start']) && isset($_GET['end'])) {
  $selected = true;
  $start=$_GET['start'];
  $end=$_GET['end'];
  $query = "SELECT * FROM pulseLog WHERE DATE(timeStamp) BETWEEN '$start' AND '$end'";
  $selection = "between_" . $start . "_and_" . $end . "";
}

///// if nothing selected above
if (!$selected) {
  $query = "SELECT * FROM pulseLog";
  $selection = "since start";
}

return $query;

?>
