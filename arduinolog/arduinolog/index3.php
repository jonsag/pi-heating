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

<html>
<head>
<title>JS Arduino pulseLog</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />

  <?php
  // Load the calendar class
  require('calendar/tc_calendar.php');
?>

</head>

<title>JS Arduino pulseLog</title>
<body>
<h1><center>Js ArduinoLog</center></h1>

<form name="calendar" method="post" action="">
  <table>
  <tr>
  <td>

  <?php
  // Call the calendar constructor - use the desired form and format, according to the instructions/samples provided on triconsole.com
  $myCalendar = new tc_calendar("date1", true);
$myCalendar->setIcon("calendar/images/iconCalendar.gif");
$myCalendar->setDate(date('d'), date('m'), date('Y'));
$myCalendar->setPath("calendar/");
$myCalendar->zindex = 150; //default 1
$myCalendar->setYearInterval(1960, date('Y'));
$myCalendar->dateAllow('1960-03-01', date('Y-m-d'));
//$myCalendar->autoSubmit(true, "calendar");
$myCalendar->disabledDay("sat");
$myCalendar->disabledDay("sun");
$myCalendar->setAlignment('right', 'bottom'); //optional
$myCalendar->writeScript();
?>

</td>
</tr>
</table>
</form>

<br>
Click on a link to see graph of temps and currents<br>

<br>
<a href="myJPGraph.php?months=3">Last 3 months</a><br>
  <br>
  <a href="myJPGraph.php?weeks=2">Last 2 weeks</a><br>
  <br>
  <a href="myJPGraph.php?days=30">Last 30 days</a><br>
  <br>
  <a href="myJPGraph.php?hours=24">Last 24 hours</a><br>
  <br>
  
  
  <br>
  <a href="myJPGraph.php?this=year">This year</a><br>
  <br>
  <a href="myJPGraph.php?this=month">This month</a><br>
  <br>
  <a href="myJPGraph.php?this=week">This week</a><br>
  <br>
  <a href="myJPGraph.php?this=day">Today</a><br>
  <br>
  
  <br>
  <a href="myJPGraph.php?last=year">Last year</a><br>
  <br>
  <a href="myJPGraph.php?last=month">Last month</a><br>
  <br>
  <a href="myJPGraph.php?last=week">Last week</a><br>
  <br>
  <a href="myJPGraph.php?last=day">Yesterday</a><br>
  <br>
  
  <br>
  <a href="myJPGraph.php">Everything</a><br>
  <br>
  
  <br>
  <a href="printData.php">Print MySQL data</a><br>
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

<br>
<br>
<!--
<input type="button" name="button4" id="button4" value="<?php echo(L_CHK_VAL); ?>" onClick="javascript:alert('Date interval selected from '+this.form.date4.value+' to '+this.form.date5.value);">
--!>


<input type="button" name="button4" id="button4" value="Show graph" onClick="parent.location='myJPGraph.php?start='+this.form.date4.value+'&&end='+this.form.date5.value">
</form>
 
</body>
</html>
