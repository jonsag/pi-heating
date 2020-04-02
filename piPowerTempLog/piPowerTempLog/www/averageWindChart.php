<html>
<head>
<title>piPowerTempLog - average wind chart</title>
<script type="text/javascript"
	src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  	google.charts.load('current', {'packages':['corechart']});
  	google.charts.setOnLoadCallback(drawChart);

  	function drawChart() {
  	var data = google.visualization.arrayToDataTable([

<?php
include ("config.php");
include ('functions/functions.php');
include ('functions/getSql.function.php');
require_once ('functions/SqlFormatter.php');

$selected = false;

// /// catch attributes
if (isset($_GET['time'])) {
    $timeSelection = $_GET['time'];
}

if (isset($_GET['table'])) {
    $table = $_GET['table'];
}

if (isset($_GET['groupBy'])) {
    $answer = create_selection($_GET['groupBy']);
    $groupby = $answer[0];
    $groupedby = $answer[1];
    $selection = $answer[2];
} else {
    $groupby = "GROUP BY ts";
    $groupedby = "";
    $selection = "ts";
}

$selection .= ", averageWindSpeed";

echo "['Time','Average wind speed']";

$condition = "";

$answer = getSQL($table, $selection, $groupby);

$sql = $answer[0];
$selection = $answer[1];

//echo $sql;
$result = $conn->query($sql);

// read result
while ($row = $result->fetch_assoc()) {
    // $rows++;
    echo ",\n['";
    echo $row['ts'];
    echo "', ";
    echo $row['averageWindSpeed'];
    echo "]";
}

echo "\n]);\n\n";



echo "var options = {\n";
echo " title:' " . $table . " - Average wind speed ";
echo $selection;
if ($groupedby) {
    echo ", grouped by " . $groupedby;
}
// echo ", sql= " . $sql;
echo "',\n";
// echo " width: 1200,\n";
// echo " height: 550,\n";
// echo " lineWidth: 1\n";
// echo " colors: ['red', 'green', 'blue']\n";
echo " curveType: 'function',\n";
echo " legend: { position: 'bottom' },\n";

$answer = getSQL($table, "MAX(averageWindSpeed) as max", $groupby);
$sql2= $answer[0];
$selection = $answer[1];
// echo "<br>\n" . $sql . "<br>\n";
$result = $conn->query($sql2);
$row = ($result->fetch_assoc());
$maxValue = $row['max'];
chartOptions1(0, $maxValue);

echo "};\n";

// close connection to mysql
mysqli_close($conn);

?>

  var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
  chart.draw(data, options);
}

    </script>
</head>
<body>
	<div id="curve_chart" style="width: 1350px; height: 600px"></div>

<?php

lf();
echo "SQL: \n" . SqlFormatter::format($sql);

?>

</body>
</html>

