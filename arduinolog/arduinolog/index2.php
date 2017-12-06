<?php
// Request selected language - by Ciprian

$hl = (isset($_POST["hl"])) ? $_POST["hl"] : false;
if(!defined("L_LANG") || L_LANG == "L_LANG")
  {
    if($hl) define("L_LANG", $hl);
    else define("L_LANG", "en_US");
  }

$langs='calendar/lang/';
$langfiles = opendir($langs); #open directory
$i = 0;
while (false !== ($langfile = readdir($langfiles)))
  {
    if (!stristr($langfile,"html") && !stristr($langfile,"localization") && !stristr($langfile,"xx_YY") && $langfile!=='.' && $langfile!=='..')
      {
	$hl=str_replace("calendar.","",$langfile);
	$hl=str_replace(".","",$hl);
	$hl=str_replace("php","",$hl);
	$langsfile[]=$hl;
	$i++;
      }
  }
if ($langsfile)
  {
   array_push($langsfile, "en_US");
    natsort($langsfile);
  }
closedir($langfiles);

?>

<html>

<head>
<title>JS Arduino pulseLog</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />

<?php
  require_once('calendar/tc_calendar.php');
?>

<style type="text/css">
  body { font-size: 11px; font-family: "verdana"; }

pre { font-family: "verdana"; font-size: 10px; background-color: #FFFFCC; padding: 5px 5px 5px 5px; }
pre .comment { color: #008000; }
pre .builtin { color: #FF0000; }
</style>

<body>
<h1><center>Js ArduinoLog</center></h1>



<br>
Click on a link to see graph of temps and currents<br>

<br>
<a href='myJPGraph.php?months=3'>Last 3 months</a><br>
  <br>
<a href='myJPGraph.php?weeks=2'>Last 2 weeks</a><br>
  <br>
<a href='myJPGraph.php?days=30'>Last 30 days</a><br>
  <br>
<a href='myJPGraph.php?hours=24'>Last 24 hours</a><br>
  <br>


<br>
  <a href='myJPGraph.php?this=year'>This year</a><br>
<br>
  <a href='myJPGraph.php?this=month'>This month</a><br>
<br>
  <a href='myJPGraph.php?this=week'>This week</a><br>
<br>
  <a href='myJPGraph.php?this=day'>Today</a><br>
<br>

  <br>
<a href='myJPGraph.php?last=year'>Last year</a><br>
  <br>
<a href='myJPGraph.php?last=month'>Last month</a><br>
  <br>
<a href='myJPGraph.php?last=week'>Last week</a><br>
<br>
<a href='myJPGraph.php?last=day'>Yesterday</a><br>
  <br>

<br>
  <a href='myJPGraph.php'>Everything</a><br>
<br>

  <br>
<a href='printData.php'>Print MySQL data</a><br>
  <br>
  </body>

</html>


