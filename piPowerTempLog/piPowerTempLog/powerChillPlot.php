<html>
<head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

  var data = google.visualization.arrayToDataTable([
						    ['Chill factor', 'Power'],

    <?php
    include ('config.php');
    include ('getSql.php');

    $samples = 30;
    $counter = 0;
    $plots = 0;
    $values = 0;

    // connect to mysql
    if (! $db_con) {
        die('Could not connect: ' . mysqli_error());
    }

    // select database
    mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));

    $query = mysqli_query($db_con, $sql);

    // read result
    while ($row = mysqli_fetch_array($query)) {

        $time = substr($row['ts'], 0, - 3);

        // /// find average wind
        $weatherSql = "SELECT averageWindSpeed FROM `weatherLog` WHERE `ts` LIKE '{$time}%'";
        $result = mysqli_query($db_con, $weatherSql);
        if ($result) {
            // $averageWindSpeed = (mysqli_result($result,0));
            $averageWindSpeed = mysqli_fetch_array($result);
        } else {
            die('Invalid query: ' . mysqli_error($db_con));
        }

        // /// find temp
        $deviceSql = "SELECT id FROM 1wireDevices WHERE place='ute'";
        $result = mysqli_query($db_con, $deviceSql);
        if ($result) {
            $id = (mysqli_result($result, 0));
        } else {
            die('Invalid query: ' . mysqli_error($db_con));
        }
        $deviceSql = "SELECT temp1 FROM `tempLog` WHERE `ts` LIKE '{$time}%'";
        $result = mysqli_query($deviceSql);
        if ($result) {
            $temp = (mysqli_result($result, 0));
        } else {
            die('Invalid query: ' . mysqli_error());
        }

        $chillFactor = round((13.12 + 0.6215 * $temp - 13.956 * pow($averageWindSpeed, 0.16) + 0.48669 * $temp * pow($averageWindSpeed, 0.16)), 2, PHP_ROUND_HALF_UP);

        if (! empty($row['currentAverageR1']) && ! empty($row['currentAverageS2']) && ! empty($row['currentAverageT3']) && ! empty($averageWindSpeed) && ! empty($temp)) {
            if ($counter < $samples) {
                $accR1 = $accR1 + $row['currentAverageR1'];
                $accS2 = $accS2 + $row['currentAverageS2'];
                $accT3 = $accT3 + $row['currentAverageT3'];
                $accChill = $accChill + $chillFactor;
                $counter ++;
                $values ++;
            } else {
                echo "[ {$accChill} / {$samples}, ({$accR1} + {$accS2} + {$accT3}) * 230 * 1.732 / 1000 / {$samples} ]";
                echo ",\n";
                $accR1 = 0;
                $accS2 = 0;
                $accT3 = 0;
                $accChill = 0;
                $counter = 0;
                $plots ++;
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
echo "'Power/Chill ";
echo $selection . " - ";
echo $plots . " plots - ";
echo $values . " values";
echo "',";
?>
  vAxis: {title: 'Power', minValue: 0, maxValue: 10},
  hAxis: {title: 'Chill factor', minValue: -15, maxValue: 15},
  width: 1200,
  height: 550,
  legend: 'none',
  pointSize:1,
  colors: ['red']
  };

  var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

    </script>
</head>
<body>
	<div id="chart_div"></div>
</body>
</html>