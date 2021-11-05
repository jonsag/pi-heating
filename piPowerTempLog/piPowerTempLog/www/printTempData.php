 <?php
    include("config.php");
    include('functions/functions.php');
    include('functions/getSql.function.php');

    $selected = false;

    ///// catch attributes
    if (isset($_GET['time'])) {
        $timeSelection = $_GET['time'];
    }

    if (isset($_GET['table'])) {
        $table = $_GET['table'];
    }

    // find sensor ids
    $sql = "SELECT id FROM sensors";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sensorids = [];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            ++$i;
            $sensorids[$i] = $row['id'];
        }
    }

    // create selection
    $selection = "ts";
    $i = 0;
    foreach ($sensorids as $sensorid) {
        $selection .= ", ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END), 1) AS sensor" . $sensorid;
    }

    $condition = "";
    $groupby = "GROUP BY ts";

    $answer = getSQL($table, $selection, $groupby);

    $sql = $answer[0];
    $selection = $answer[1];

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        print "<table border cellpadding=3>\n";
        print "<tr><td colspan=18>" . $table . " " . $selection;
        lf();
        print "sql=" . $sql . "</td></tr>\n";
        print "<th>Timestamp</th>";
        foreach ($sensorids as $sensorid) {
            print "<th>Sensor " . $sensorid . "</th>";
        }
        print "</tr>\n";
        while ($row = $result->fetch_assoc()) {
            print "<tr>";
            print "<th>" . $row['ts'] . "</th> ";
            //Print "<td>" . $row['sensorid'] . "</td>";
            foreach ($sensorids as $sensorid) {
                print "<th>" . $row["sensor" . $sensorid] . "</th>";
            }
            print "</tr>\n";
        }
        print "</table>";
    }

    // close connection to mysql
    mysqli_close($conn);

    ?> 
