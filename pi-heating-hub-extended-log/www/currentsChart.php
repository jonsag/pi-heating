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
     
     if(isset($_GET['groupBy'])) {
         if ($_GET['groupBy'] == "hour") {
             $groupby = " GROUP BY HOUR(ts)";
         }
         else if ($_GET['groupBy'] == "day") {
             $groupby = " GROUP BY DAY(ts)";
         }
         else if ($_GET['groupBy'] == "week") {
             $groupby = " GROUP BY WEEK(ts)";
         }
         else if ($_GET['groupBy'] == "month") {
             $groupby = " GROUP BY MONTH(ts)";
         }
         else if ($_GET['groupBy'] == "year") {
             $groupby = " GROUP BY YEAR(ts)";
         }
     }
     else {
         $groupby = "GROUP BY ts";
     }
     
    $rows = 0;

    // create selection
    $selection = "ts, currentAverageR1, currentAverageS2, currentAverageT3";
    
    $condition = " AND 'currentR1'!='0'";
    
    $answer = getSQL($selection, $table, $condition, $groupby);
    
    $sql = $answer[0];
    $selection = $answer[1];
    
    $result = $conn->query($sql);
    
    $noRows = mysqli_num_rows($result);
        
    echo "['Time', 'R1', 'S2', 'T3'],";
    // read result
    while($row = $result->fetch_assoc()) {
      $rows++;
      echo "\n['";
      echo $row['ts'];
      echo "',";
      echo $row['currentAverageR1'];
      echo ",";
      echo $row['currentAverageS2'];
      echo ",";
      echo $row['currentAverageT3'];
      echo"],";
    }

    // close connection to mysql
    mysqli_close($conn);;

    echo "\n]);\n\n";

  echo "var options = {\n";
  echo "title:"; 
  echo "'" . $table . " - Average currents ";
  echo $selection;
  //echo ", sql=" . $sql;
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
