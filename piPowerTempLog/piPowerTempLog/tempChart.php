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
       die('Could not connect: ' . mysqli_error());
     }
     
     // select database
     mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));
     
     $placeSql = "SELECT * FROM 1wireDevices WHERE deviceType='temp'";
     
     $query = mysqli_query($db_con, $placeSql);

     echo "['Time', ";
     
     while($row = mysqli_fetch_array($query)) {
       echo "'" . $row['place'] . "',";
     }
     
     echo "],";
     
    // select sql
    //$sql = "SELECT * FROM powerLog";
    // do the query
     $query = mysqli_query($db_con, $sql);
    
    // read result
     while($row = mysqli_fetch_array($db_con, $query)) {
      $rows++;
      echo "['{$row['ts']}', {$row['temp0']}, {$row['temp1']}]";
      echo ",\n";
    }

    // close connection to mysql
    mysqli_close($db_con);
    ?>

    ]);

  var options = {
  title: 

<?php

echo "'" . $table . " - Temps ";
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