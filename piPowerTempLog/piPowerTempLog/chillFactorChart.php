<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

<?php

include ('config.php');
include ('functions/functions.php');

include ('functions/getSql.function.php');

$counter1 = 0;
$counter2 = 0;
$table = "tempLog";

$answer = getSQL($table, $_GET);

///// connect to database
if (!$db_con) {
  die('Could not connect: ' . mysqli_error());
}

///// choose database
mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));

$sql = "SELECT id FROM 1wireDevices WHERE place='ute'";

$result = mysqli_query($db_con, $sql);

if ($result) {
  //$id = (mysqli_result($result,0));
    $id = mysqli_fetch_array($result);
}
else {
  die('Invalid query: ' . mysqli_error());
}

$query = mysqli_query($answer[0]);

while($tempRow = mysqli_fetch_array( $query )) {
  $timeStamp[$counter1] = $tempRow['ts'];
  $outdoorTemp[$counter1] = $tempRow[1 + $id];
  
  $time = substr($tempRow['ts'], 0, -3);
  $sql = "SELECT averageWindSpeed FROM `weatherLog` WHERE `ts` LIKE '{$time}%'";
  $result = mysqli_query($sql);
  if ($result) {
    $averageWindSpeed[$counter1] = (mysqli_result($result,0));
    if (!empty($averageWindSpeed[$counter1])) {
      $chillFactor[$counter1] = round((13.12 + 0.6215 * $outdoorTemp[$counter1] - 13.956 * pow($averageWindSpeed[$counter1], 0.16) + 0.48669 * $outdoorTemp[$counter1] * pow($averageWindSpeed[$counter1], 0.16)), 2, PHP_ROUND_HALF_UP);
      $counter1++;
    }
  }
  else {
    die('Invalid query: ' . mysqli_error());
  }
}

// close connection to mysql
mysqli_close($db_con);

?>
var data = google.visualization.arrayToDataTable([
						  ['Time', 'temp', 'wind', 'chill'],

<?php
  for ($counter2; $counter2 <= $counter1 - 1; $counter2++) {
    echo "['{$timeStamp[$counter2]}', {$outdoorTemp[$counter2]}, {$averageWindSpeed[$counter2]}, {$chillFactor[$counter2]}]";
    echo ",\n";
  }
?>

  ]);

var options = {
title:'wind chill factor',
width: 1200,
height: 550,
lineWidth: 1,

colors: ['red', 'black', 'blue']
};

var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
chart.draw(data, options);
}

    </script>
  </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html> 
