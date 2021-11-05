<?php
    
    ///// include configuration file
    include ('config.php');
    include ('functions/functions.php');
    
    ///// debug argument
    if ($argv[1] == "") {
        $debug = 0;
    }
    else {
        $debug = $argv[1];
    }
    
    if ($_GET['debug']) {
        $debug = 1;
    }
    
    ///// poll argument
    if ($argv[2] == "") {
        $poll = 0;
    }
    else {
        $poll = $argv[2];
    }
    
    if ($_GET['poll']) {
        $poll = 1;
    }
    
    ///// event argument
    if ($_GET['event'] != "") {
        $event = $_GET['event'];
    }
    
    if ($argv[3] != "") {
        $event = $argv[3];
    }
    
    $thisTime =  date('Y\-m\-d\ H\:i\:s');
    if ($debug) {
        echo "Time is " . $thisTime;
        lf();
        echo "-----------------------------------------------------";
        lf();
    }
    
    $sql = "SELECT * FROM sensors where unit='deg C'";
    $result = $conn->query($sql);
    
    if ($debug) {
        echo "There are " . $result->num_rows. " temp-sensors present in db";
        lf();
        echo "-----------------------------------------------------";
        lf();
    }
    
    if ($result->num_rows > 0) {
        $sql = "";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $sensorid = $row["id"];
            $value = $row["value"];
            $sql .= "INSERT INTO tempLog (ts, sensorid, value, event) VALUES ('$thisTime', '$sensorid', '$value', '$event');";
        }
    }
    
    if ($debug) {
        echo "sql: " . $sql;
        lf();
        echo "-----------------------------------------------------";
        lf();
    }
    
    if ($conn->multi_query($sql) === TRUE) {
        if ($debug) {
            echo "New records created successfully";
        }
    } else {
        if ($debug) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // close connection to mysql
    mysqli_close($conn);;
