<html>
  <head>
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript">
  	google.charts.load('current', {'packages':['corechart']});
  	google.charts.setOnLoadCallback(drawChart);

  	function drawChart() {
  	var data = google.visualization.arrayToDataTable([

<?php
    // Turn off all error reporting
    error_reporting(0);
    
     include ("config.php");
     include ('functions/functions.php');
     include ('functions/getSql.function.php');

     if (isset($_GET['table'])) {
         $table = $_GET['table'];
     }
     
    $rows = 0;

    // create selection
    $selection = "ts, currentAverageR1, currentAverageS2, currentAverageT3";
    
    $condition = " AND 'currentR1'!='0'";
    $groupby = "GROUP BY ts";
    
    $answer = getSQL($selection, $table, $condition, $groupby);
    
    $sql = $answer[0];
    $selection = $answer[1];
    
    $result = $conn->query($sql);
    
    $noRows = mysqli_num_rows($result);
        
    echo "['Time', 'R1', 'S2', 'T3'],";
    // read result
    while($row = $result->fetch_assoc()) {
      $rows++;
      echo "\n['" . $row['ts'] . "'," .  $row['currentAverageR1'] . "," .  $row['currentAverageS2'] . "," . $row['currentAverageT3'] . "],";
    }

    // close connection to mysql
    mysqli_close($conn);;

    echo "\n]);\n\n";

  echo "var options = {\n";
  echo "title:"; 
  echo "'" . $table . " - Average currents ";
  echo $selection;
  echo ", sql=" . $sql;
  echo "',\n";

//echo "width: 1200,\n";
//echo "height: 550,\n";
//echo "lineWidth: 1,\n";

  //echo "colors: ['black', 'brown', 'blue']\n";
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
