<html>

<head>
  <title>piPowerTempLog - power/chill factor plot</title>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load("visualization", "1", {
      packages: ["corechart"]
    });
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Chill factor', 'Power'],

        <?php
        include('config.php');
        include('getSql.php');

        $samples = 30;
        $counter = 0;
        $plots = 0;
        $values = 0;

        // connect to mysql
        if (!$db_con) {
          die('Could not connect: ' . mysql_error());
        }

        // select database
        mysql_select_db($db_name) or die(mysql_error());

        $query = mysql_query($sql);

        // read result
        while ($row = mysql_fetch_array($query)) {

          $time = substr($row['ts'], 0, -3);

          ///// find average wind
          $weatherSql = "SELECT averageWindSpeed FROM `weatherLog` WHERE `ts` LIKE '{$time}%'";
          $result = mysql_query($weatherSql);
          if ($result) {
            $averageWindSpeed = (mysql_result($result, 0));
          } else {
            die('Invalid query: ' . mysql_error());
          }

          ///// find temp
          $deviceSql = "SELECT id FROM 1wireDevices WHERE place='ute'";
          $result = mysql_query($deviceSql);
          if ($result) {
            $id = (mysql_result($result, 0));
          } else {
            die('Invalid query: ' . mysql_error());
          }
          $deviceSql = "SELECT temp1 FROM `tempLog` WHERE `ts` LIKE '{$time}%'";
          $result = mysql_query($deviceSql);
          if ($result) {
            $temp = (mysql_result($result, 0));
          } else {
            die('Invalid query: ' . mysql_error());
          }

          $chillFactor = round((13.12 + 0.6215 * $temp - 13.956 * pow($averageWindSpeed, 0.16) + 0.48669 * $temp * pow($averageWindSpeed, 0.16)), 2, PHP_ROUND_HALF_UP);

          if (!empty($row['currentAverageR1']) && !empty($row['currentAverageS2']) && !empty($row['currentAverageT3']) && !empty($averageWindSpeed) && !empty($temp)) {
            if ($counter < $samples) {
              $accR1 = $accR1 + $row['currentAverageR1'];
              $accS2 = $accS2 + $row['currentAverageS2'];
              $accT3 = $accT3 + $row['currentAverageT3'];
              $accChill = $accChill + $chillFactor;
              $counter++;
              $values++;
            } else {
              echo "[ {$accChill} / {$samples}, ({$accR1} + {$accS2} + {$accT3}) * 230 * 1.732 / 1000 / {$samples} ]";
              echo ",\n";
              $accR1 = 0;
              $accS2 = 0;
              $accT3 = 0;
              $accChill = 0;
              $counter = 0;
              $plots++;
            }
          }
        }

        // close connection to mysql
        mysql_close($db_con);
        ?>

      ]);

      var options = {
        title: <?php
                echo "'Power/Chill ";
                echo $selection . " - ";
                echo $plots . " plots - ";
                echo $values . " values";
                echo "',";
                ?>
        vAxis: {
          title: 'Power',
          minValue: 0,
          maxValue: 10
        },
        hAxis: {
          title: 'Chill factor',
          minValue: -15,
          maxValue: 15
        },
        width: 1200,
        height: 550,
        legend: 'none',
        pointSize: 1,
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