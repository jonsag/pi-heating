<?php
// Request selected language
$hl = (isset($_POST["hl"])) ? $_POST["hl"] : false;
if(!defined("L_LANG") || L_LANG == "L_LANG")
  {
    if($hl) define("L_LANG", $hl);
    else define("L_LANG", "en_US"); // Greek example
  }
// IMPORTANT: Request the selected date from the calendar
$mydate = isset($_POST["date1"]) ? $_POST["date1"] : "";
?>

  <?php
///// include configuration file
include ('config.php');
// Load the calendar class
require('calendar/tc_calendar.php');
?>

<html>
<head>
<title>JS Arduino pulseLog</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />

<script type="text/javascript">
  function count_rows()
{
  alert(result);
}
</script>

</head>

<body>
<h1><center>JS ArduinoLog</center></h1>

<form>

<br>
Pick a predefined interval<br>
-------------------------------------------------<br>
<select name="predef_interval">
<option value="months=3">Last 3 months</option>
<option value="weeks=2">Last 2 weeks</option>
<option value="days=30">Last 30 days</option>
<option value="hours=24">Last 24 hours</option>
<option value="this=year">This year</option>
<option value="this=month">This month</option>
<option value="this=week">This week</option>
<option value="this=day">Today</option>
<option value="last=year">Last year</option>
<option value="last=month">Last month</option>
<option value="last=week">Last week</option>
<option value="last=day">Yesterday</option>
<option value="">Everything</option>
</select>

<input type="button" name="button10" id="button10" value="How many rows will this generate?" onClick="parent.location='countRows.php?'+this.form.predef_interval.value">
<br>
<br>

<input type="button" name="button1" id="button1" value="Show graph" onClick="parent.location='jpGraph.php?'+this.form.predef_interval.value">
<input type="button" name="button2" id="button2" value="Print table" onClick="parent.location='printData.php?'+this.form.predef_interval.value">
<input type="button" name="button3" id="button3" value="Create excel" onClick="parent.location='excelData.php?'+this.form.predef_interval.value">
<input type="button" name="button5" id="button5" value="Create csv" onClick="parent.location='csvData.php?'+this.form.predef_interval.value">

</form>
<br>

<br>
Specify an interval<br>
-------------------------------------------------<br>
  
  <form>
  
  <?php
  $thisweek = date('W');
$thisyear = date('Y');

function getDaysInWeek ($weekNumber, $year, $dayStart = 1) {
  // Count from '0104' because January 4th is always in week 1
  // (according to ISO 8601).
  $time = strtotime($year . '0104 +' . ($weekNumber - 1).' weeks');
  // Get the time of the first day of the week
  $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
  // Get the times of days 0 -> 6
  $dayTimes = array ();
  for ($i = 0; $i < 7; ++$i) {
    $dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
  }
  // Return timestamps for mon-sun.
  return $dayTimes;
}

$dayTimes = getDaysInWeek($thisweek, $thisyear);
//----------------------------------------

$date4_default = date('Y-m-d', $dayTimes[0]);
$date5_default = date('Y-m-d', $dayTimes[(sizeof($dayTimes)-1)]);
?>
  
  <?php
$myCalendar = new tc_calendar("date4", true, false);
$myCalendar->setIcon("calendar/images/iconCalendar.gif");
$myCalendar->setDate(date('d', strtotime($date4_default)), date('m', strtotime($date4_default)), date('Y', strtotime($date4_default)));
$myCalendar->setPath("calendar/");
$myCalendar->setYearInterval(1970, 2020);
//$myCalendar->dateAllow('2009-02-20', "", false);
$myCalendar->setAlignment('left', 'bottom');
$myCalendar->setDatePair('date4', 'date5', $date5_default);
$myCalendar->writeScript();

$myCalendar = new tc_calendar("date5", true, false);
$myCalendar->setIcon("calendar/images/iconCalendar.gif");
$myCalendar->setDate(date('d', strtotime($date5_default)), date('m', strtotime($date5_default)), date('Y', strtotime($date5_default)));
$myCalendar->setPath("calendar/");
$myCalendar->setYearInterval(1970, 2020);
//$myCalendar->dateAllow("", '2009-11-03', false);
$myCalendar->setAlignment('right', 'bottom');
$myCalendar->setDatePair('date4', 'date5', $date4_default);
$myCalendar->writeScript();
?>

<input type="button" name="button10" id="button10" value="How many rows will this generate?" onClick="parent.location='countRows.php?start='+this.form.date4.value+'&&end='+this.form.date5.value">
<br>
<br>

<input type="button" name="button4" id="button4" value="Show graph" onClick="parent.location='jpGraph.php?start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button6" id="button6" value="Print table" onClick="parent.location='printData.php?start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button7" id="button7" value="Create excel" onClick="parent.location='excelData.php?start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button8" id="button8" value="Create csv" onClick="parent.location='csvData.php?start='+this.form.date4.value+'&&end='+this.form.date5.value">

</form>

<br>
View poller page<br>
-------------------------------------------------<br>
<a href="arduinoPoller.php">arduinoPoller.php</a> 

<br>
<br>
<br>
Actual Arduino webserver<br>
-------------------------------------------------

<?php
  $html = file($url);

///// how many lines in this file
$numLines = count($html);

///// process each line
for ($i = 0; $i < $numLines; $i++) {
  // use trim to remove the carriage return and/or line feed character
  // at the end of line
  $line = trim($html[$i]);
  Print $line . "\n";
}
?>

</body>
</html>