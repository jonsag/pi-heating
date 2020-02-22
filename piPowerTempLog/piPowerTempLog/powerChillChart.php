<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

  var data = google.visualization.arrayToDataTable([
						    ['Time', 'Power kW', 'Temp', 'Chill factor'],

    <?php
    include ('config.php');
    include ('getSql.php');

    // connect to mysql
    if (!$db_con) {
      die('Could not connect: ' . mysqli_error());
    }

    // select database
    mysqli_select_db($db_name) or die(mysqli_error());
    
    $query = mysqli_query($sql);
    
    // read result
    while($row = mysqli_fetch_array($query)) {

      $time = substr($row['ts'], 0, -3);

      ///// find average wind
      $weatherSql = "SELECT averageWindSpeed FROM `weatherLog` WHERE `ts` LIKE '{$time}%'";
      $result = mysqli_query($weatherSql);
      if ($result) {
	$averageWindSpeed = (mysqli_result($result,0));
      }
      else {
	die('Invalid query: ' . mysqli_error());
      }

      ///// find temp
      $deviceSql = "SELECT id FROM 1wireDevices WHERE place='ute'";
      $result = mysqli_query($deviceSql);
      if ($result) {
	$id = (mysqli_result($result,0));
      }
      else {
	die('Invalid query: ' . mysqli_error());
      }
      $deviceSql = "SELECT temp1 FROM `tempLog` WHERE `ts` LIKE '{$time}%'";
      $result = mysqli_query($deviceSql);
      if ($result) {
        $temp = (mysqli_result($result,0));
      }
      else {
        die('Invalid query: ' . mysqli_error());
      }

      $chillFactor = round((13.12 + 0.6215 * $temp - 13.956 * pow($averageWindSpeed, 0.16) + 0.48669 * $temp * pow($averageWindSpeed, 0.16)), 2, PHP_ROUND_HALF_UP);

      if ( !empty($row['currentAverageR1']) && !empty($row['currentAverageS2']) && !empty($row['currentAverageT3']) && !empty($averageWindSpeed) && !empty($temp) ) {
	//	echo "['{$row['ts']}', ({$row['currentAverageR1']} + {$row['currentAverageS2']} + {$row['currentAverageT3']}) * 230 * 1.732 / 1000, , {$temp}, {$chillFactor}]";
        echo "['{$row['ts']}', ({$row['currentAverageR1']} + {$row['currentAverageS2']} + {$row['currentAverageT3']}) * 230 * 1.732 / 1000, {$temp}, {$chillFactor}]";
	echo ",\n";
      }
    }

    // close connection to mysql
    mysqli_close($db_con);
    ?>

    ]);

  var options = {
  title:
<?php
  echo "'Power/Temp/Chill - ";
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