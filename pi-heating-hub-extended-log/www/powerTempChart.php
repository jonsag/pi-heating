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

$groupby = "GROUP BY ts";
$groupedby = "";
$selection = "ts";

// find sensor ids
$sql = "SELECT id FROM sensors";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sensorids = [];
    $i = 0;
    echo "['Time'";
    echo ", 'kW'";
    while ($row = $result->fetch_assoc()) {
        ++ $i;
        $sensorids[$i] = $row['id'];
        $namesql = "SELECT name FROM sensors WHERE id='" . $row['id'] . "'";
        $nameresult = $conn->query($namesql);
        if ($result->num_rows > 0) {
            while ($namerow = $nameresult->fetch_assoc()) {
                echo ", '";
                echo trim($namerow['name']);
                // echo " &deg;C";
                // echo " &#x2103;";
                echo " \u00B0C";
                echo "'";
            }
        }
    }
    echo "]";
}

$i = 0;
foreach ($sensorids as $sensorid) {
    $selection .= ", ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END), 1) AS sensor" . $sensorid;
}

$condition = "";

$answer = getSQL($selection, $table, $condition, $groupby);

$sql = $answer[0];
$selection = $answer[1];

$result = $conn->query($sql);

// read result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output = ",\n['";
        $output .= $row['ts'];
        $output .= "'";
        
        $powerSql = "SELECT ts, currentAverageR1, currentAverageS2, currentAverageT3 FROM powerLog WHERE ";
        $powerSql .= "ts > DATE_SUB('" . $row['ts'] . "', INTERVAL 1 MINUTE) AND ";
        $powerSql .= "ts < DATE_ADD('" . $row['ts'] . "', INTERVAL 1 MINUTE) ";
        $powerSql .= "LIMIT 1";
        // echo $powerSql;
        $powerResult = $conn->query($powerSql);
        
        $output .= ", ";
        if ($powerResult->num_rows > 0) {
            while ($powerRow = $powerResult->fetch_assoc()) {
                $output .= ($powerRow['currentAverageR1'] + $powerRow['currentAverageS2'] + $powerRow['currentAverageT3']) * 230 * 1.732 / 1000;
            }
        } else {
            $output .= "0";
        }
        
        foreach ($sensorids as $sensorid) {
            $output .= ", ";
            $output .= $row['sensor' . $sensorid];
        }
        $output .= "]";
        echo $output;
    }
}

echo "\n]);\n\n";

// close connection to mysql
mysqli_close($conn);
;

echo "var options = {\n";
echo " title:' powerLog, " . $table . " - Power and temps ";
echo $selection;
if ($groupedby) {
    echo ", grouped by " . $groupedby;
}
echo "',\n";
// echo " width: 1200,\n";
// echo " height: 550,\n";
// echo " lineWidth: 1\n";
// echo " colors: ['red', 'green', 'blue']\n";
echo " curveType: 'function',\n";
echo " legend: { position: 'bottom' }\n";
echo "};\n";
?>

  var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
  chart.draw(data, options);
}

    </script>
</head>
<body>
	<div id="curve_chart" style="width: 1350px; height: 600px"></div>
</body>
</html>
