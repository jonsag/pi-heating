<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

  var data = google.visualization.arrayToDataTable([

     <?php
     include ('config.php');
     include ('getSql.php');
     
     // connect to mysql
     if (!$db_con) {
       die('Could not connect: ' . mysql_error());
     }
     
     // select database
     mysql_select_db($db_name) or die(mysql_error());
     
     echo "['Time','Average wind speed'],";
     
    // select sql
    //$sql = "SELECT * FROM powerLog";
    // do the query
    $query = mysql_query($sql);
    
    // read result
    while($row = mysql_fetch_array($query)) {
      $rows++;
      echo "['{$row['ts']}', {$row['averageWindSpeed']}]";
      echo ",\n";
    }

    // close connection to mysql
    mysql_close($db_con);
    ?>

  ]);

  var options = {
  title: 

<?php

echo "'" . $table . " - Average wind speed ";
echo $selection;
echo "',";

?>

  width: 1200,
  height: 550,
  lineWidth: 1,

  colors: ['red', 'green', 'blue']
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
