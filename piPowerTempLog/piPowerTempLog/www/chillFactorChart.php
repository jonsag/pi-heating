<html>

<head>
    <title>piPowerTempLog - chill factor chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        <?php
                        include('config.php');
                        include('functions/functions.php');
                        include('functions/getSql.function.php');
                        require_once('functions/SqlFormatter.php');

                        $selected = false;

                        // /// catch attributes
                        if (isset($_GET['time'])) {
                            $timeSelection = $_GET['time'];
                        }

                        if (isset($_GET['table'])) {
                            $table = $_GET['table'];
                        }

                        if (isset($_GET['groupBy'])) {
                            $answer = create_selection($_GET['groupBy']);
                            $groupby = $answer[0];
                            $groupedby = $answer[1];
                            $selection = $answer[2];
                        } else {
                            $groupby = "GROUP BY ts";
                            $groupedby = "";
                            $selection = "ts";
                        }

                        $counter1 = 0;
                        $counter2 = 0;
                        $table = "tempLog";

                        // find sensor ids
                        $sql = "SELECT id FROM sensors WHERE name LIKE 'Ute%'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $sensorids = [];
                            $i = 0;
                            echo "['Time'";
                            echo ", 'Chill factor \u00B0C'";
                            echo ", 'Wind m/s'";
                            while ($row = $result->fetch_assoc()) {
                                ++$i;
                                $sensorids[$i] = $row['id'];
                                $namesql = "SELECT name FROM sensors WHERE id='" . $row['id'] . "'";
                                $nameresult = $conn->query($namesql);
                                if ($result->num_rows > 0) {
                                    while ($namerow = $nameresult->fetch_assoc()) {
                                        echo ", '";
                                        echo trim($namerow['name']);
                                        echo " \u00B0C";
                                        echo "'";
                                    }
                                }
                            }
                            echo "]";
                        }

                        foreach ($sensorids as $sensorid) {
                            if ($groupedby) {
                                $selection .= ", AVG(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END) AS sensor" . $sensorid;
                            } else {
                                $selection .= ", MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END) AS sensor" . $sensorid;
                            }
                        }

                        $condition = "";

                        $answer = getSQL($selection, $table, $condition, $groupby);

                        $sql = $answer[0];
                        $selection = $answer[1];

                        $result = $conn->query($sql);

                        // read result
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $output = ",\n['";
                                $output .= $row['ts'];
                                $output .= "'";

                                // $weatherSql = "SELECT ts, currentAverageR1, currentAverageS2, currentAverageT3 ";
                                $weatherSql = "SELECT ";
                                if ($groupedby) {
                                    $weatherSql .= "AVG(averageWindSpeed) AS averageWindSpeed ";
                                } else {
                                    $weatherSql .= "averageWindSpeed ";
                                }
                                $weatherSql .= "FROM weatherLog WHERE ";
                                // $weatherSql .= "ts > DATE_SUB('" . $row['ts'] . "', INTERVAL 1 ". $groupedby . ") AND ";
                                // $weatherSql .= "ts < DATE_ADD('" . $row['ts'] . "', INTERVAL 1 ". $groupedby . ") ";
                                if ($groupedby) {
                                    $weatherSql .= "DATE(ts) = DATE('" . $row['ts'] . "') AND HOUR(ts) = HOUR('" . $row['ts'] . "')";
                                } else {
                                    $weatherSql .= "ts > DATE_SUB('" . $row['ts'] . "', INTERVAL 1 MINUTE) AND ";
                                    $weatherSql .= "ts < DATE_ADD('" . $row['ts'] . "', INTERVAL 1 MINUTE) ";
                                }
                                if ($groupedby) {
                                    $weatherSql .= $groupby;
                                } else {
                                    $weatherSql .= "LIMIT 1 ";
                                }
                                //echo "<br>\n" . $weatherSql . "<br>\n";
                                $weatherResult = $conn->query($weatherSql);

                                $output .= ", ";
                                if ($weatherResult->num_rows > 0) {
                                    while ($weatherRow = $weatherResult->fetch_assoc()) {
                                        $outdoorTemp = $row['sensor5'];
                                        $averageWindSpeed = $weatherRow['averageWindSpeed'];
                                        $chillFactor = round((13.12 + 0.6215 * $outdoorTemp - 13.956 * pow($averageWindSpeed, 0.16) + 0.48669 * $outdoorTemp * pow($averageWindSpeed, 0.16)), 2, PHP_ROUND_HALF_UP);

                                        //$windc = round((13.12 + 0.6215 * $c - 11.37 * pow($kmh,0.16) + 0.3965 * $c * pow($kmh,0.16)), 1);
                                        $c = $outdoorTemp;
                                        $kmh = $averageWindSpeed * 3.6;
                                        $windc = round((13.12 + 0.6215 * $c - 11.37 * pow($kmh, 0.16) + 0.3965 * $c * pow($kmh, 0.16)), 1);

                                        //$windc = getWindChill($kmh, $c);

                                        $output .= $windc;
                                        //$output .= $chillFactor;
                                        $output .= ", ";
                                        $output .= $averageWindSpeed;
                                    }
                                } else {
                                    $output .= "0";
                                }

                                foreach ($sensorids as $sensorid) {
                                    $output .= ", ";
                                    $output .= $row['sensor' . $sensorid];
                                }
                                $output .= "]";
                                echo $output;
                            }
                        }

                        echo "\n]);\n\n";

                        // close connection to mysql
                        mysqli_close($conn);

                        echo "var options = {\n";
                        echo " title:' Chill factor, " . $table . " - Wind and temps ";
                        echo $selection;
                        if ($groupedby) {
                            echo ", grouped by " . $groupedby;
                        }
                        echo "',\n";
                        // echo " width: 1200,\n";
                        // echo " height: 550,\n";
                        // echo " lineWidth: 1\n";
                        // echo " colors: ['red', 'green', 'blue']\n";
                        echo " curveType: 'function',\n";
                        echo " legend: { position: 'bottom' },\n";

                        chartOptions1(-10, 10);

                        echo "};\n";
                        ?>

                        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                        chart.draw(data, options);
                    }
    </script>
</head>

<body>
    <div id="curve_chart" style="width: 1350px; height: 600px"></div>

    <?php

    lf();
    echo "SQL: \n" . SqlFormatter::format($sql);

    dlf();
    echo "Last SQL to get weather: \n" . SqlFormatter::format($weatherSql);

    ?>

</body>

</html>