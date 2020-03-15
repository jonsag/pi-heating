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

// $groupby = "GROUP BY ts";
// $groupedby = "";
// $selection = "ts";

// find sensor ids
$sql = "SELECT id FROM sensors";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sensorids = [];
    $i = 0;
    echo "['Time'";
    while ($row = $result->fetch_assoc()) {
        ++ $i;
        $sensorids[$i] = $row['id'];
        $namesql = "SELECT name FROM sensors WHERE id='" . $row['id'] . "'";
        $nameresult = $conn->query($namesql);
        if ($result->num_rows > 0) {
            while ($namerow = $nameresult->fetch_assoc()) {
                echo ", '";
                echo trim($namerow['name']);
                echo " \u00B0C";
                echo "'";
            }
        }
    }
    echo "]";
}

foreach ($sensorids as $sensorid) {
    if ($groupedby) {
        // $selection .= ", ROUND(AVG(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END)), 1) AS sensor" . $sensorid;
        // $selection .= ", AVG(ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN AVG(value) ELSE 0 END), 1)) AS sensor" . $sensorid;
        // $selection .= ", ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END), 1) AS sensor" . $sensorid;
        $selection .= ", AVG(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END) AS sensor" . $sensorid;
    } else {
        // $selection .= ", ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END), 1) AS sensor" . $sensorid;
        $selection .= ", MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END) AS sensor" . $sensorid;
    }
}

$condition = "";

$answer = getSQL($table, $selection, $groupby);

$sql = $answer[0];
$selection = $answer[1];

// echo "<br>\n" . $sql . "<br>\n";
$result = $conn->query($sql);

// read result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output = ",\n['";
        $output .= $row['ts'];
        $output .= "'";
        foreach ($sensorids as $sensorid) {
            $output .= ", " . $row['sensor' . $sensorid];
        }
        $output .= "]";
        echo $output;
    }
}

echo "\n]);\n\n";

echo "var options = {\n";
echo " title:' " . $table . " - Temps ";
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

$answer = getSQL($table, "MIN(value) as min, MAX(value) as max",  $groupby);
$sql2 = $answer[0];
$selection = $answer[1];
// echo "<br>\n" . $sql . "<br>\n";
$result = $conn->query($sql2);
$row = ($result->fetch_assoc());
$minValue = $row['min'];
$maxValue = $row['max'];
chartOptions1($minValue, $maxValue);

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
