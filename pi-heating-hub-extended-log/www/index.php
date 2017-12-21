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

    ///// include configuration file
    include ('config.php');
    include ('functions/functions.php');
    // Load the calendar class
    require('calendar/tc_calendar.php');
?>

<html>
<head>
<title>JS Power Temp Log</title>
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
<div style="text-align:center">
<h1>JS Power Temp Log</h1>
- part of pi-heating -
</div>
<br>

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

<input type="button" name="button1" id="button1" value="How many rows will this generate?" onClick="parent.location='countRows.php?'+this.form.predef_interval.value">
<br>
  Number of values displayed: 
<select name="no_of_values">
<option value="">All</option>
<option value="values=1000">1000</option>
<option value="values=500">500</option>
<option value="values=100">100</option>
<option value="values=50">50</option>
<option value="values=20">20</option>
</select>
<br>
  Group by: 
<select name="group_by">
<option value="">No grouping</option>
<option value="groupBy=hour">hour</option>
<option value="groupBy=day">day</option>
<option value="groupBy=week">week</option>
<option value="groupBy=month">month</option>
<option value="groupBy=year">year</option>
</select>
  (if set, above option does not matter)
<br>
<br>

Power<br>
-------------------------------------------------<br>
<input type="button" name="button2" id="button2" value="Show power chart" onClick="parent.location='powerChart.php?table=powerLog&'+this.form.predef_interval.value+'&'+this.form.no_of_values.value+'&'+this.form.group_by.value">
<input type="button" name="button3" id="button3" value="Print power table" onClick="parent.location='printPowerData.php?table=powerLog&'+this.form.predef_interval.value">
<input type="button" name="button4" id="button4" value="Create power excel" onClick="parent.location='excelData.php?table=powerLog&'+this.form.predef_interval.value">
<input type="button" name="button5" id="button5" value="Create power csv" onClick="parent.location='csvData.php?table=powerLog&'+this.form.predef_interval.value">
<br>
<input type="button" name="button30" id="button30" value="Show currents chart" onClick="parent.location='currentsChart.php?table=powerLog&'+this.form.predef_interval.value+'&'+this.form.no_of_values.value+'&'+this.form.group_by.value">
<br>
<br>
Temps<br>
-------------------------------------------------<br>
<input type="button" name="button6" id="button6" value="Show temp chart" onClick="parent.location='tempChart.php?table=tempLog&'+this.form.predef_interval.value+'&'+this.form.no_of_values.value+'&'+this.form.group_by.value">
<input type="button" name="button7" id="button7" value="Print temp table" onClick="parent.location='printTempData.php?table=tempLog&'+this.form.predef_interval.value">
<input type="button" name="button8" id="button8" value="Create temp excel" onClick="parent.location='excelData.php?table=tempLog&'+this.form.predef_interval.value">
<input type="button" name="button9" id="button9" value="Create temp csv" onClick="parent.location='csvData.php?table=tempLog&'+this.form.predef_interval.value">
<br>
<br>
Weather<br>
-------------------------------------------------<br>
<input type="button" name="button19" id="button19" value="Show average wind chart" onClick="parent.location='averageWindChart.php?table=weatherLog&'+this.form.predef_interval.value+'&'+this.form.no_of_values.value+'&'+this.form.group_by.value">
<input type="button" name="button20" id="button20" value="Print weather table" onClick="parent.location='printWeatherData.php?table=weatherLog&'+this.form.predef_interval.value">
<input type="button" name="button21" id="button21" value="Create weather excel" onClick="parent.location='excelData.php?table=weatherLog&'+this.form.predef_interval.value">
<input type="button" name="button22" id="button22" value="Create weather csv" onClick="parent.location='csvData.php?table=weatherLog&'+this.form.predef_interval.value">
<br>
<input type="button" name="button27" id="button27" value="Show chill factor chart" onClick="parent.location='chillFactorChart.php?'+this.form.predef_interval.value+'&'+this.form.no_of_values.value">
<input type="button" name="button28" id="button28" value="Print chill factor table" onClick="parent.location='printChillFactorData.php?'+this.form.predef_interval.value">
<br>
<br>
Combined<br>
-------------------------------------------------<br>
<input type="button" name="button33" id="button33" value="Show power/temp chart" onClick="parent.location='powerTempChart.php?table=tempLog&'+this.form.predef_interval.value+'&'+this.form.no_of_values.value">
<br>
<input type="button" name="button29" id="button29" value="Show power/chill chart" onClick="parent.location='powerChillChart.php?table=powerLog&'+this.form.predef_interval.value+'&'+this.form.no_of_values.value">
<br>
<input type="button" name="button32" id="button32" value="Show power/chill plot" onClick="parent.location='powerChillPlot.php?table=powerLog&'+this.form.predef_interval.value">
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

Power<br>
-------------------------------------------------<br>
<input type="button" name="button11" id="button11" value="Show power chart" onClick="parent.location='powerChart.php?table=powerLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button12" id="button12" value="Print power table" onClick="parent.location='printPowerData.php?table=powerLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button13" id="button13" value="Create power excel" onClick="parent.location='excelData.php?table=powerLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button14" id="button14" value="Create power csv" onClick="parent.location='csvData.php?table=powerLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<br>
<input type="button" name="button31" id="button31" value="Show currents chart" onClick="parent.location='currentsChart.php?table=powerLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<br>
<br>
Temps<br>
-------------------------------------------------<br>
<input type="button" name="button15" id="button16" value="Show temp chart" onClick="parent.location='tempChart.php?table=tempLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button16" id="button16" value="Print temp table" onClick="parent.location='printTempData.php?table=tempLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button17" id="button17" value="Create temp excel" onClick="parent.location='excelData.php?table=tempLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button18" id="button18" value="Create temp csv" onClick="parent.location='csvData.php?table=tempLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<br>
<br>
Weather<br>
-------------------------------------------------<br>
<input type="button" name="button23" id="button23" value="Show average wind chart" onClick="parent.location='averageWindChart.php?table=weatherLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button24" id="button24" value="Print weather table" onClick="parent.location='printWeatherData.php?table=weatherLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button25" id="button25" value="Create weather excel" onClick="parent.location='excelData.php?table=weatherLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<input type="button" name="button26" id="button26" value="Create weather csv" onClick="parent.location='csvData.php?table=weatherLog&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<br>
<br>
Combined<br>
-------------------------------------------------<br>
<input type="button" name="button34" id="button33" value="Show power/temp chart" onClick="parent.location='powerTempChart.php?table=tempLog&&start='+this.form.date4.value+'&&end='+this.form.date5.value">
<br>
</form>

<br>
View poller pages<br>
-------------------------------------------------<br>
<a href="powerPoller.php">powerPoller.php</a>
<br>
<!--<a href="tempPoller.php">tempPoller.php</a>
<br>-->
<a href="weatherPoller.php">weatherPoller.php</a>
<br>
<br>
<?php

echo "Actual power webserver - " . gethostbyaddr($powerIP);
    lf();

    echo '<a href="' . $powerUrl . '">' . $powerUrl . '</a>';
    lf();
    echo "-------------------------------------------------";
    lf();
    $html = file($powerUrl);
    $numLines = count($html);
    for ($i = 0; $i < $numLines; $i++) {
      $line = trim($html[$i]);
      Print $line . "\n";
    }
    dlf();

    
	//echo "Actual raspberry02 webserver - temp";
	//lf();

    //echo '<a href="' . $tempUrl . '">' . $tempUrl . '</a>';
    //lf();
    //echo "-------------------------------------------------";
    //dlf();
    //$html = file($tempUrl);
    //$numLines = count($html);
    //for ($i = 0; $i < $numLines; $i++) {
    //  $line = trim($html[$i]);
    //  Print $line . "\n";
    //}
    //dlf();

    echo "Actual weather webserver - " . gethostbyaddr($weatherIP);
	lf();

    echo '<a href="' . $weatherUrl . '">' . $weatherUrl . '</a>';
    lf();
    echo "-------------------------------------------------";
    dlf();
    $html = file($weatherUrl);
    $numLines = count($html);
    for ($i = 0; $i < $numLines; $i++) {
      $line = trim($html[$i]);
      Print $line . "\n";
    }
    dlf();
?>

</body>
</html>
