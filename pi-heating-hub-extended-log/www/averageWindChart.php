<html>
  <head>
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
     
     ///// catch attributes
     if (isset($_GET['time'])) {
         $timeSelection = $_GET['time'];
     }
     
     if (isset($_GET['table'])) {
         $table = $_GET['table'];
     }
     
     if(isset($_GET['groupBy'])) {
         if ($_GET['groupBy'] == "hour") {
             $groupby = " GROUP BY DATE(ts), HOUR(ts)";
             $groupedby = "hour";
         }
         else if ($_GET['groupBy'] == "day") {
             $groupby = " GROUP BY DAY(ts)";
             $groupedby = "day";
         }
         else if ($_GET['groupBy'] == "week") {
             $groupby = " GROUP BY WEEK(ts)";
             $groupedby = "week";
         }
         else if ($_GET['groupBy'] == "month") {
             $groupby = " GROUP BY MONTH(ts)";
             $groupedby = "month";
         }
         else if ($_GET['groupBy'] == "year") {
             $groupby = " GROUP BY YEAR(ts)";
             $groupedby = "year";
         }
     }
     else {
         $groupby = "GROUP BY ts";
         $groupedby = "";
     }
     
     echo "['Time','Average wind speed']";
     
     // create selection
     if ($groupedby == "hour") {
         $selection = "DATE_FORMAT(ts, '%Y-%m-%d %H:%i') AS ts";
     }
     else if ($groupedby == "day") {
         $selection = "DATE_FORMAT(ts, '%Y-%m-%d') AS ts";
     }
     else if ($groupedby == "week") {
         $selection = "DATE_FORMAT(ts, '%Y-%m-%d') AS ts";;
     }
     else if ($groupedby == "month") {
         $$selection = "DATE_FORMAT(ts, '%Y-%m') AS ts";
     }
     else if ($groupedby == "year") {
         $selection = "DATE_FORMAT(ts, '%Y') AS ts";
     }
     else {
         $selection = "ts";
     }
     
     $selection .= ", averageWindSpeed";
     $condition = "";
     
     $answer = getSQL($selection, $table, $condition, $groupby);
     
     $sql = $answer[0];
     $selection = $answer[1];
     
     //echo $sql;
     $result = $conn->query($sql);
    
    // read result
     while($row = $result->fetch_assoc()) {
      //$rows++;
      echo ",\n['";
      echo $row['ts'];
      echo "', ";
      echo $row['averageWindSpeed'];
      echo "]";
    }
    
    echo "\n]);\n\n";

    // close connection to mysql
    mysqli_close($conn);;

    echo "var options = {\n";
    echo " title:' " . $table . " - Average wind speed ";
    echo $selection;
    if ($groupedby) {
        echo ", grouped by " . $groupedby;
    }
    //echo ", sql= " . $sql;
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

