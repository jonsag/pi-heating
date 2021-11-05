<html>

<head>
  <title>piPowerTempLog - power/chill factor chart</title>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load("visualization", "1", {
      packages: ["corechart"]
    });
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Time', 'Power kW', 'Temp', 'Chill factor'],

        <?php
        include('config.php');
        include('getSql.php');

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
            //	echo "['{$row['ts']}', ({$row['currentAverageR1']} + {$row['currentAverageS2']} + {$row['currentAverageT3']}) * 230 * 1.732 / 1000, , {$temp}, {$chillFactor}]";
            echo "['{$row['ts']}', ({$row['currentAverageR1']} + {$row['currentAverageS2']} + {$row['currentAverageT3']}) * 230 * 1.732 / 1000, {$temp}, {$chillFactor}]";
            echo ",\n";
          }
        }

        // close connection to mysql
        mysql_close($db_con);
        ?>

      ]);

      var options = {
        title: <?php
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

  <?php

  lf();
  echo "SQL = : " . $sql;

  ?>
</body>

</html>