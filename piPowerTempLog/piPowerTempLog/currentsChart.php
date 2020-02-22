<html>
<head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

  var data = google.visualization.arrayToDataTable([
    ['Time', 'R1', 'S2', 'T3'],

    <?php
    include ('config.php');
    include ('getSql.php');

    $rows = 0;

    // connect to mysql
    if (! $db_con) {
        die('Could not connect: ' . mysqli_error());
    }

    // select database
    mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));

    $newSql = $sql . " AND 'currentR1'!='0'";

    $query = mysqli_query($db_con, $sql);

    // read result
    while ($row = mysqli_fetch_array($query)) {
        $rows ++;
        echo "['{$row['ts']}', {$row['currentAverageR1']}, {$row['currentAverageS2']}, {$row['currentAverageT3']}]";
        echo ",\n";
    }

    // close connection to mysql
    mysqli_close($db_con);
    ?>

    ]);

  var options = {
  title: 
<?php
echo "'" . $table . " - Average currents ";
echo $selection;
echo ", sql=" . $sql;
echo "',";
?>
  width: 1200,
  height: 550,
  lineWidth: 1,

  colors: ['black', 'brown', 'blue']
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