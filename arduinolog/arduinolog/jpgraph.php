<?php 
///// config file
include ('config.php');

///// jpgraph libraries
require_once ('jpgraph/jpgraph.php');   
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_date.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_utils.inc.php');
require_once ('jpgraph/jpgraph_mgraph.php');

///// define arrays
$i = 0;
$id = array();
$timeStamp = array();
$currentTime = array();
$diffTime = array();
$unixTime = array();
$currentR1 = array();
$currentS2 = array();
$currentT3 = array();
$currentAverageR1 = array();
$currentAverageS2 = array();
$currentAverageT3 = array();
$temp0 = array();
$temp1 = array();
$temp2 = array();
$temp3 = array();
$temp4 = array();
$temp5 = array();
$pulses = array();


///// catch attributes
$timeSelection = $_GET['time'];

///// connect to database
if (!$db_con) {
  die('Could not connect: ' . mysql_error());
}

///// choose database
mysql_select_db($db_name) or die(mysql_error());

/////
///// query mysql
/////
///// last number of months, days, hours
if (isset($_GET['years'])) {
  $yearss = $_GET['years'];
  $query = mysql_query("SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $years YEAR) <= timeStamp")
    or die(mysql_error());
  $selection = "last " . $years . " years";
}

if (isset($_GET['months'])) {
  $months = $_GET['months'];
  $query = mysql_query("SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $months MONTH) <= timeStamp")
    or die(mysql_error());
  $selection = "last " . $months . " months";
}

if (isset($_GET['weeks'])) {
  $weeks = $_GET['weeks'];
  $query = mysql_query("SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $weeks MONTH) <= timeStamp")
    or die(mysql_error());
  $selection = "last " . $weeks . " weeks";
}


if (isset($_GET['days'])) {
  $days = $_GET['days'];
  $query = mysql_query("SELECT * FROM pulseLog WHERE DATE_SUB(CURDATE(),INTERVAL $days DAY) <= timeStamp")
        or die(mysql_error());
  $selection = "last " . $days . " days";
}

if (isset($_GET['hours'])) {
  $hours = $_GET['hours'];
  $query = mysql_query("SELECT * FROM pulseLog WHERE DATE_SUB(NOW(),INTERVAL $hours HOUR) <= timeStamp")
    or die(mysql_error());
  $selection = "last " . $hours . " hours";
}

///// this year month, week, yesterday
if (isset($_GET['this'])) {
  if ($_GET['this'] == "year") {

    //    or die(mysql_error());
    $selection = "this year";
 }
  if ($_GET['this'] == "month") {

    //    or die(mysql_error());
    $selection = "this month";
  }
  if ($_GET['this'] == "week") {

    //    or die(mysql_error());
    $selection = "this week";
  }
  if ($_GET['this'] == "day") {
    $query = mysql_query("SELECT * FROM pulseLog WHERE DATE(timeStamp) = CURDATE()")
      or die(mysql_error());
    $selection = "today";
  }
}

///// last year month, week, yesterday
if (isset($_GET['last'])) {
  if ($_GET['last'] == "year") {

    //    or die(mysql_error());
    $selection = "last year";
  }
  if ($_GET['last'] == "month") {

    //    or die(mysql_error());
    $selection = "last month";
  }
  if ($_GET['last'] == "week") {

    //    or die(mysql_error());
    $selection = "last week";
  }
  if ($_GET['last'] == "day") {
    $query = mysql_query("SELECT * FROM pulseLog WHERE DATE(timeStamp) = CURDATE() - 1")
    or die(mysql_error());
    $selection = "yesterday";
  }
}

//if ($timeSelection == "everything" || $timeSelection = "") {
//  $query = mysql_query("SELECT * FROM pulseLog")
//    or die(mysql_error());
//  $selection = "since start";
//}


//Print $time . , "<br>";


///// read data
while($row = mysql_fetch_array($query)) 
  { 
    $id[$i] = $row['id'];

    $thisTime = $row['timeStamp'];
    list($date, $time) = explode(' ', $thisTime);
    list($year, $month, $day) = explode('-', $date);
    list($hour, $minute, $second) = explode(':', $time);
    $timeStamp[$i] = mktime($hour, $minute, $second, $month, $day, $year);

    $unixTime[$i] = $row['unixTime'];
    
    $currentR1[$i] = abs($row['currentR1']);
    ///// check for unnatural data
    if ($currentR1[$i] > 30 && $i > 0) {
      $currentR1[$i] = $currentR1[$i-1];
    }

    $currentS2[$i] = abs($row['currentS2']);
    ///// check for unnatural data
    if ($currentS2[$i] > 30 && $i > 0) {
      $currentS2[$i] = $currentS2[$i-1];
    }

    $currentT3[$i] = abs($row['currentT3']);
    ///// check for unnatural data
    if ($currentT3[$i] > 30 && $i > 0) {
      $currentT3[$i] = $currentT3[$i-1];
    }

    $currentAverageR1[$i] = abs($row['currentAverageR1']);
    ///// check for unnatural data
    if ($currentAverageR1[$i] > 30 && $i > 0) {
      $currentAverageR1[$i] = $currentAverageR1[$i-1];
    }

    $currentAverageS2[$i] = abs($row['currentAverageS2']);
    ///// check for unnatural data
    if ($currentAverageS2[$i] > 30 && $i > 0) {
      $currentAverageS2[$i] = $currentAverageS2[$i-1];
    }

    $currentAverageT3[$i] = abs($row['currentAverageT3']);
    ///// check for unnatural data
    if ($currentAverageT3[$i] > 30 && $i > 0) {
      $currentAverageT3[$i] = $currentAverageT3[$i-1];
    }


    $temp0[$i] = $row['temp0'];
    ///// check for unnatural data
    if (abs($temp0[$i]-$temp0[$i-1]) > 20 && $i > 0) {
      $temp0[$i] = $temp0[$i-1];
    }
    $temp1[$i] = $row['temp1'];
    ///// check for unnatural data
    if (abs($temp1[$i]-$temp1[$i-1]) > 20 && $i > 0) {
      $temp1[$i] = $temp1[$i-1];
    }

    $pulses[$i] = $row['pulses'];

    //    echo $id[$i], " ", $thisTime, " ", $temp0[$i], " ", $temp1[$i], " ", $pulses[$i], "<br>\n";

    $i++;
  } 

///// We add some grace to the end of the X-axis scale so that the first and last
///// data point isn't exactly at the very end or beginning of the scale
$graceMin = 300;
$graceMax = 10;
$xmin = $timeStamp[0] - $graceMin;
$xmax = $timeStamp[$i-1] + $graceMax;;

// Overall width of graphs
$width = 1000;
// Left and right margin for each graph
$leftMargin=60; $rightMargin=15;


/////----------------------
///// Setup the temp graph
/////----------------------
$tempGraph = new Graph($width,500);
$tempGraph->SetScale('datlin',0,0,$xmin,$xmax);
$tempGraph->SetMargin($leftMargin,$rightMargin,30,120);
$tempGraph->SetMarginColor('white');
$tempGraph->SetFrame(false);
$tempGraph->SetBox(true);
$tempGraph->title->SetFont(FF_ARIAL,FS_BOLD);
$tempGraph->title->Set("pulseLog ".$selection);
$tempGraph->xaxis->SetFont(FF_ARIAL);
$tempGraph->xaxis->SetLabelAngle(65);
$tempGraph->xgrid->Show();
$tempGraph->yaxis->title->SetFont(FF_ARIAL);
$tempGraph->yaxis->title->Set("Celsius");

///// temp0
$temp0Line = new LinePlot($temp0,$timeStamp);
$temp0Line ->SetLegend('temp0');
$temp0Line->SetColor('green');

///// temp1
$temp1Line = new LinePlot($temp1,$timeStamp);
$temp1Line->SetLegend('temp1');
$temp1Line->SetColor('red');

///// order to draw the lines
$tempGraph->Add($temp0Line);
$tempGraph->Add($temp1Line);

/////----------------------
///// Setup the current graph
/////----------------------
$currentGraph = new Graph($width,220);
$currentGraph->SetScale('datlin',0,0,$xmin,$xmax);
$currentGraph->SetMargin($leftMargin,$rightMargin,30,30);
$currentGraph->SetMarginColor('white');
$currentGraph->SetFrame(false);
$currentGraph->SetBox(true);
$currentGraph->xaxis->HideLabels();
$currentGraph->xgrid->Show();
$currentGraph->yaxis->title->SetFont(FF_ARIAL);
$currentGraph->yaxis->title->Set("Ampere");

///// currentR1
$currentR1Line = new LinePlot($currentAverageR1,$timeStamp);
$currentR1Line->SetLegend('currentR1');
$currentR1Line->SetColor('black');

///// currentS2
$currentS2Line = new LinePlot($currentAverageS2,$timeStamp);
$currentS2Line->SetLegend('currentS2');
$currentS2Line->SetColor('brown');

///// currentT3
$currentT3Line = new LinePlot($currentAverageT3,$timeStamp);
$currentT3Line->SetLegend('currentT3');
$currentT3Line->SetColor('blue');

///// order to draw the lines
$currentGraph->Add($currentR1Line);
$currentGraph->Add($currentS2Line);
$currentGraph->Add($currentT3Line);

/////----------------------
///// Setup the bar graph
/////----------------------
$pulseGraph = new Graph($width,150);
$pulseGraph->SetScale('datlin',0,0,$xmin,$xmax);
$pulseGraph->SetMargin($leftMargin,$rightMargin,30,30);
$pulseGraph->SetMarginColor('white');
$pulseGraph->SetFrame(false);
$pulseGraph->SetBox(true);
$pulseGraph->xgrid->Show();
$pulseGraph->xaxis->HideLabels();


///// pulses
$pulseBar = new BarPlot($pulses,$timeStamp);
$pulseBar->SetLegend("pulses");

///// draw the bars
$pulseGraph->Add($pulseBar);

/////-----------------------
///// Create a multigraph
/////----------------------
$multigraph = new MGraph();
$multigraph->SetMargin(2,2,2,2);
$multigraph->SetFrame(true,'darkgray',2);
///// add the different charts
$multigraph->Add($tempGraph);
$multigraph->Add($currentGraph,0,490);
$multigraph->Add($pulseGraph,0,700);
///// draw the charts
$multigraph->Stroke();

?> 
