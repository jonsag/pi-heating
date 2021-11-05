<html>

<head>
    <title>piPowerTempLog - power chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([

                        <?php
                        include("config.php");
                        include('functions/functions.php');
                        include('functions/getSql.function.php');
                        require_once('functions/SqlFormatter.php');

                        // /// catch attributes
                        if (isset($_GET['time'])) {
                            $timeSelection = $_GET['time'];
                        }

                        if (isset($_GET['table'])) {
                            $table = $_GET['table'];
                        }

                        if (isset($_GET['values']) && !isset($_GET['groupBy'])) {
                            $values = $_GET['values'];
                        } else {
                            $values = 0;
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

                        $R1 = 0;
                        $S2 = 0;
                        $T3 = 0;
                        $counter = 0;
                        $valuesDisplayed = 0;

                        if ($groupedby) {
                            $selection .= ", AVG(currentAverageR1) AS currentAverageR1, AVG(currentAverageS2) AS currentAverageS2, AVG(currentAverageT3) AS currentAverageT3";
                            // $selection = "ts, currentAverageR1, currentAverageS2, currentAverageT3";
                        } else {
                            $selection .= ", currentAverageR1, currentAverageS2, currentAverageT3";
                        }

                        $condition = "";

                        $answer = getSQL($table, $selection, $groupby);

                        $sql = $answer[0];
                        $selection = $answer[1];

                        $result = $conn->query($sql);

                        $noRows = mysqli_num_rows($result);

                        if ($values) {
                            $averages = round($noRows / $values, 0, PHP_ROUND_HALF_UP);
                        } else {
                            $averages = 1;
                        }

                        echo "['Time', 'kW'],";
                        // read result
                        while ($row = $result->fetch_assoc()) {
                            if (!empty($row['currentAverageR1']) && !empty($row['currentAverageS2']) && !empty($row['currentAverageT3'])) {
                                if ($values) {
                                    $R1 = $R1 + $row['currentAverageR1'];
                                    $S2 = $S2 + $row['currentAverageS2'];
                                    $T3 = $T3 + $row['currentAverageT3'];
                                    $counter++;
                                    if ($counter >= $averages) {
                                        echo "\n['";
                                        echo $row['ts'];
                                        echo "',";
                                        echo ($R1 + $S2 + $T3) * 230 * 1.732 / 1000 / $counter;
                                        echo "],";
                                        $R1 = 0;
                                        $S2 = 0;
                                        $T3 = 0;
                                        $counter = 0;
                                        $valuesDisplayed++;
                                    }
                                } else {
                                    echo "\n['";
                                    echo $row['ts'];
                                    echo "', ";
                                    echo ($row['currentAverageR1'] + $row['currentAverageS2'] + $row['currentAverageT3']) * 230 * 1.732 / 1000;
                                    echo "],";
                                    $valuesDisplayed++;
                                }
                            }
                        }

                        // close connection to mysql
                        mysqli_close($conn);;

                        echo "\n]);\n\n";

                        echo "var options = {\n";
                        echo "title:";
                        echo "'" . $table . " - Power ";
                        echo $selection;
                        if ($values) {
                            echo ", averaging to " . $valuesDisplayed . " values, " . $averages . " measurements per point";
                        } else if ($groupedby) {
                            echo ", grouped by " . $groupedby;
                        }
                        // echo ", sql=" . $sql;
                        echo "',\n";
                        // echo " colors: ['red','blue']\n";
                        echo " curveType: 'function',\n";
                        echo " legend: { position: 'bottom' },\n";
                        chartOptions1(0, 10);
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

    ?>

</body>

</html>