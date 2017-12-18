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
     
     $selected = false;
     
     ///// catch attributes
     if (isset($_GET['time'])) {
         $timeSelection = $_GET['time'];
     }
     
     if (isset($_GET['table'])) {
         $table = $_GET['table'];
     }
     
     
     // find sensor ids
     $sql = "SELECT id FROM sensors";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
         $sensorids = [];
         $i = 0;
         echo "['Time'";
         while($row = $result->fetch_assoc()) {
             ++$i;
             $sensorids[$i] = $row['id'];
             $namesql = "SELECT name FROM sensors WHERE id='" . $row['id'] . "'";
             $nameresult = $conn->query($namesql);
             if ($result->num_rows > 0) {
                 while($namerow = $nameresult->fetch_assoc()) {
                     echo ", '";
                     echo trim($namerow['name']);
                     echo " \u00B0C";
                     echo "'";
                 }
             }
         }
         echo "]";
     }
     
     // create selection
     $selection = "ts";
     $i = 0;
     foreach ($sensorids as $sensorid) {
         $selection .= ", ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END), 1) AS sensor" . $sensorid;
     }
     
     $condition = "";
     $groupby = "GROUP BY ts";
     
     $answer = getSQL($selection, $table, $condition, $groupby);
     
     $sql = $answer[0];
     $selection = $answer[1];
     
     $result = $conn->query($sql);
    
     // read result
     if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
             $output = ",\n['";
             $output .= $row['ts'];
             $output .= "'";
             foreach ($sensorids as $sensorid) {
                 $output .= ", {$row['sensor' . $sensorid]}";
             }
             $output .= "]";
             echo $output;
         }
     }
     
     echo "\n]);\n\n";

    // close connection to mysql
    mysqli_close($conn);;
    
    echo "var options = {\n";
    echo " title:' " . $table . " - Temps ";
    echo $selection;
    echo "',\n";
    //echo " width: 1200,\n";
    //echo " height: 550,\n";
    //echo " lineWidth: 1\n";
    //echo " colors: ['red', 'green', 'blue']\n";
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
