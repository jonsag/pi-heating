<?php

function getSQL($selection, $table, $condition, $groupby) {

  ///// last number of months, days, hours
  if (isset($_GET['years'])) {
    $selected = true;
    $years = $_GET['years'];
    $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $years YEAR) <= ts " . $groupby;
    $selection = "last " . $years . " years";
  }
  
  if (isset($_GET['months'])) {
    $selected = true;
    $months = $_GET['months'];
    $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $months MONTH) <= ts " . $groupby;
    $selection = "last " . $months . " months";
  }
  
  if (isset($_GET['weeks'])) {
    $selected = true;
    $weeks = $_GET['weeks'];
    $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $weeks WEEK) <= ts " . $groupby;
    $selection = "last " . $weeks . " weeks";
  }
  
  
  if (isset($_GET['days'])) {
    $selected = true;
    $days = $_GET['days'];
    $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $days DAY) <= ts " . $groupby;
    $selection = "last " . $days . " days";
  }
  
  if (isset($_GET['hours'])) {
    $selected = true;
    $hours = $_GET['hours'];
    $sql = "SELECT $selection FROM $table WHERE DATE_SUB(NOW(),INTERVAL $hours HOUR) <= ts " . $groupby;
    $selection = "last " . $hours . " hours";
  }
  
  ///// this year month, week, yesterday
  if (isset($_GET['this'])) {
    $selected = true;
    if ($_GET['this'] == "year") {
      $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE()) " . $groupby;
      $selection = "this year";
    }
    if ($_GET['this'] == "month") {
      $sql = "SELECT $selection FROM $table WHERE MONTH(ts) = MONTH(CURDATE()) " . $groupby;
      $selection = "this month";
    }
    if ($_GET['this'] == "week") {
      $sql = "SELECT $selection FROM $table WHERE WEEK(ts) = WEEK(CURDATE()) " . $groupby;
      $selection = "this week";
    }
    if ($_GET['this'] == "day") {
        $sql = "SELECT $selection FROM $table WHERE DATE(ts) = CURDATE() " . $groupby;
      $selection = "today";
    }
  }
  
  ///// last year month, week, yesterday
  if (isset($_GET['last'])) {
    $selected = true;
    if ($_GET['last'] == "year") {
        $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE()) - 1 " . $groupby;
      $selection = "last year";
    }
    if ($_GET['last'] == "month") {
        $sql = "SELECT $selection FROM $table WHERE MONTH(ts) = MONTH(CURDATE()) - 1 " . $groupby;
      $selection = "last month";
    }
    if ($_GET['last'] == "week") {
        $sql = "SELECT $selection FROM $table WHERE WEEK(ts) = WEEK(CURDATE()) - 1 " . $groupby;
      $selection = "last week";
    }
    if ($_GET['last'] == "day") {
        $sql = "SELECT $selection FROM $table WHERE DATE(ts) = CURDATE() - 1 " . $groupby;
      $selection = "yesterday";
    }
  }
  
  ///// date interval
  if (isset($_GET['start']) && isset($_GET['end'])) {
    $selected = true;
    $start=$_GET['start'];
    $end=$_GET['end'];
    $sql = "SELECT $selection FROM $table WHERE DATE(ts) BETWEEN '$start' AND '$end' " . $groupby;
    $selection = "between " . $start . " and " . $end . "";
  }
  
  ///// if nothing selected above
  if (!$selected) {
      $sql = "SELECT $selection FROM $table " . $groupby;
    $selection = "since start";
  }
  
  $answer[0] = $sql;
  $answer[1] = $selection;
  
  return($answer);
  
}

?>
