<?php
    ///// config file
    include ("config.php");
    include ('functions/functions.php');
    include ('functions/getSql.function.php');
    
    $selected = false;
    
    ///// catch attributes
    if (isset($_GET['time'])) {
        $timeSelection = $_GET['time'];
    }
    
    if (isset($_GET['table'])) {
        $table = $_GET['table'];
    }
    
    if ( $table == "tempLog") {
        // find sensor ids
        $sql = "SELECT id FROM sensors";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sensorids = [];
            $i = 0;
            //echo "['Time'";
            while($row = $result->fetch_assoc()) {
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
    }
    elseif ( $table == "powerLog") {
        $selection = "ts, currentR1, currentS2, currentT3, currentAverageR1, currentAverageS2, currentAverageT3, pulses";
    }
    elseif ( $table == "weatherLog") {
        $selection = "ts, windDirection, windDirectionValue, averageWindDirectionValue, windSpeed, averageWindSpeed, rainSinceLast";
    }
        
    $condition = "";
    $groupby = "GROUP BY ts";
    
    $answer = getSQL($selection, $table, $condition, $groupby);
    
    $sql = $answer[0];
    $selection = $answer[1];
    
    $query = $conn->query($sql);
    
    $fp = fopen('data.csv', "w");
    
    // fetch a row and write the column names out to the file
    $row = mysqli_fetch_assoc($query);
    $line = "";
    $comma = "";
    foreach($row as $name => $value) {
      $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
      $comma = ",";
    }
    $line .= "\n";
    fputs($fp, $line);
    
    // remove the result pointer back to the start
    mysqli_data_seek($query, 0);
    
    // and loop through the actual data
    while($row = mysqli_fetch_assoc($query)) {
      
      $line = "";
      $comma = "";
      foreach($row as $value) {
        $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
        $comma = ",";
      }
      $line .= "\n";
      fputs($fp, $line);
    }
    
    
    $file = file_get_contents('data.csv');
    $date = date('Ymd-His', time());
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="csvData-' . $table . "-". $selection . "-" . $date . '.csv"');
    header('Content-Length: ' . strlen($file));
    echo $file;
    
    unlink('data.csv');
    
    fclose($fp);
    
    // close connection to mysql
    mysqli_close($conn);;

?>
