<html>
<head>
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

if ($groupedby) {
    $selection .= ", AVG(currentAverageR1) AS currentAverageR1, AVG(currentAverageS2) AS currentAverageS2, AVG(currentAverageT3) AS currentAverageT3";
} else {
    $selection .= ", currentAverageR1, currentAverageS2, currentAverageT3";
}

$condition = " AND 'currentR1'!='0'";

$answer = getSQL($table, $selection, $groupby);

$sql = $answer[0];
$selection = $answer[1];

$result = $conn->query($sql);

$noRows = mysqli_num_rows($result);

echo "['Time', 'R1', 'S2', 'T3'],";
// read result
while ($row = $result->fetch_assoc()) {
    echo "\n['";
    echo $row['ts'];
    echo "',";
    echo $row['currentAverageR1'];
    echo ",";
    echo $row['currentAverageS2'];
    echo ",";
    echo $row['currentAverageT3'];
    echo "],";
}

// close connection to mysql
mysqli_close($conn);
;

echo "\n]);\n\n";

echo "var options = {\n";
echo "title:";
echo "'" . $table . " - Average currents ";
echo $selection;
if ($groupedby) {
    echo ", grouped by " . $groupedby;
}
// echo ", sql=" . $sql;
echo "',\n";

// echo "width: 1200,\n";
// echo "height: 550,\n";
// echo "lineWidth: 1,\n";

echo "colors: ['black', 'brown', 'blue'],\n";
echo "curveType: 'function',\n";
echo "legend: { position: 'bottom' },\n";
chartOptions1(0, 10);
echo "};\n";

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
