<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

  var data = google.visualization.arrayToDataTable([
						    ['Time', 'Power kW'],

    <?php
    include ('config.php');
    include ('getSql.php');
    
    $groupBy = "";
    $values = 1;
    

    if(isset($_GET['values']) && !isset($_GET['groupBy'])) {
      $values = $_GET['values'];
    }


    if(isset($_GET['groupBy'])) {
     if ($_GET['groupBy'] == "hour") {
       $groupBy = " GROUP BY HOUR(ts)";
     }
     else if ($_GET['groupBy'] == "day") {
       $groupBy = " GROUP BY DAY(ts)";
     }
     else if ($_GET['groupBy'] == "week") {
       $groupBy = " GROUP BY WEEK(ts)";
     }
     else if ($_GET['groupBy'] == "month") {
       $groupBy = " GROUP BY MONTH(ts)";
     }
     else if ($_GET['groupBy'] == "year") {
       $groupBy = " GROUP BY YEAR(ts)";
     }
     else {
       $groupBy = "";
     }
    }

    $counter = 0;
    $valuesDisplayed = 0;

    // connect to mysql
    if (!$db_con) {
      die('Could not connect: ' . mysqli_error());
    }

    // select database
    mysqli_select_db($db_con, $db_name) or die(mysqli_error());

    $sql = $sql . $groupBy;

    $result = mysqli_query($db_con, $sql);
    
    $noRows = mysqli_num_rows($result);

    $averages = round($noRows / $values, 0, PHP_ROUND_HALF_UP);

    // read result
    while($row = mysqli_fetch_array($result)) {
      if ( !empty($row['currentAverageR1']) && !empty($row['currentAverageS2']) && !empty($row['currentAverageT3']) ) {
	if(isset($values)) {
	  $R1 = $R1 + $row['currentAverageR1'];
	  $S2 = $S2 + $row['currentAverageS2'];
	  $T3 = $T3 + $row['currentAverageT3'];
	  $counter++;
	  if ($counter >= $averages) {
	    echo "['{$row['ts']}', ($R1 + $S2 + $T3) * 230 * 1.732 / 1000 / $counter]";
	    echo ",\n";
	    $R1 = 0;
	    $S2 = 0;
	    $T3 = 0;
	    $counter = 0;
	    $valuesDisplayed++;
	  }
	}
	else {
	  echo "['{$row['ts']}', ({$row['currentAverageR1']} + {$row['currentAverageS2']} + {$row['currentAverageT3']}) * 230 * 1.732 / 1000]";
	  echo ",\n";
	  $valuesDisplayed++;
	}
      }
    }

    // close connection to mysql
    mysqli_close($db_con);
    ?>

    ]);

  var options = {
  title:
<?php
  echo "'Power " . $selection;
  if(isset($values)) {
    echo ", averaging to " . $valuesDisplayed . " values, " . $averages . " measurements per point";
  }
  else if (isset($groupBy)) {
    echo ", grouped by " . $_GET['groupBy'];
  }
  else {
    echo ", showing all " . $valuesDisplayed . " values";
  }

  echo ", sql=" . $sql;
  echo "',";
?>

  width: 1200,
  height: 550,
  lineWidth: 1,

  curveType: 'function',

  colors: ['red','blue']
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
