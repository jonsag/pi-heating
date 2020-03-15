<html>
<head>
<title>JS Temperature</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<body>
<div style="text-align:center">
<h1>JS Temperature</h1>
- part of pi-heating -
</div>
<br>
<br>

<?php
    include ('config.php');
    include ('functions/functions.php');
        
    $sql = "SELECT * FROM sensors";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        
        $align = "center";
        $cellpadding = 0;
        $cellspacing = 30;
        
        echo "<table align=" . $align . " cellpadding=" . $cellpadding . " cellspacing=" . $cellspacing . ">\n";
        echo "<tr>" . "\n";
        
        while($row = $result->fetch_assoc()) {
            echo "<th>\n";
            $column1texts = [ "" ];
            $column2texts = [ $row["name"] ];
            $column3texts = [ "" ];
            
            array_push($column1texts, "");
            array_push($column2texts, "----------");
            array_push($column3texts, "");
            
            array_push($column1texts, "");
            array_push($column2texts, "");
            array_push($column3texts, "");
            
            array_push($column1texts, "Sensor id");
            array_push($column2texts, $row["id"]);
            array_push($column3texts, "");
            
            array_push($column1texts, "Host");
            array_push($column2texts, $row["ip"]);
            array_push($column3texts, "");
            
            array_push($column1texts, "ref");
            array_push($column2texts, $row["ref"]);
            array_push($column3texts, "");
            
            $sql3 = "SELECT COUNT(*) AS count FROM tempLog WHERE 
sensorid='" . $row["id"] . "'";
            $result3 = $conn->query($sql3);
            if ($result3->num_rows > 0) {
                while($row3 = $result3->fetch_assoc()) {
                    $noofvalues = $row3["count"];
                    array_push($column1texts, "No of values");
                    array_push($column2texts, $noofvalues);
                    array_push($column3texts, "");
                }
            }
            
            $sql4 = "SELECT 
(SELECT ts FROM tempLog WHERE 
sensorid='" . $row["id"] . "' ORDER BY ts LIMIT 1) as 'first', 
(SELECT ts FROM tempLog WHERE 
sensorid='" . $row["id"] . "' ORDER BY ts DESC LIMIT 1) as 'last'";
            $result4 = $conn->query($sql4);
            if ($result4->num_rows > 0) {
                while($row4 = $result4->fetch_assoc()) {
                    $starttime = $row4["first"];
                    $stoptime = $row4["last"];
                    array_push($column1texts, "First / last");
                    array_push($column2texts, $starttime);
                    array_push($column3texts, $stoptime);
                }
            }
            
            $difftime = abs(strtotime($stoptime) - strtotime($starttime));
            $diff = $difftime / 60;
            array_push($column1texts, "Diff");
            array_push($column2texts, round($diff) . " minutes");
            array_push($column3texts, "");
            
            array_push($column1texts, "");
            array_push($column2texts, secondsToTime(round($difftime)));
            array_push($column3texts, "");
            
            $valuesperminute = round($noofvalues / $diff, 2);
            array_push($column1texts, "Avg values/min");
            array_push($column2texts, $valuesperminute);
            array_push($column3texts, "");
            
            array_push($column1texts, "");
            array_push($column2texts, "----------");
            array_push($column3texts, "");
            
            array_push($column1texts, "");
            array_push($column2texts, "Date, time");
            array_push($column3texts, "deg C");
            
            array_push($column1texts, "");
            array_push($column2texts, date('D j/n -y, G:i', time()));
            array_push($column3texts, $row["value"]);
            
            $sql2 = "SELECT * FROM tempLog WHERE 
value=(SELECT MIN(value) FROM tempLog WHERE 
sensorid='" . $row["id"]. "') LIMIT 1";
            
            $result2 = $conn->query($sql2);
            
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    array_push($column1texts, "Lowest");
                    array_push($column2texts, date('D j/n -y, G:i', strtotime($row2["ts"])));
                    array_push($column3texts, $row2["value"]);
                }
            }

            $sql2 = "SELECT * FROM tempLog WHERE 
value=(SELECT MAX(value) FROM tempLog WHERE 
sensorid='" . $row["id"]. "') LIMIT 1";
            
            $result2 = $conn->query($sql2);
            
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    array_push($column1texts, "Highest");
                    array_push($column2texts, date('D j/n -y, G:i', strtotime($row2["ts"])));
                    array_push($column3texts, $row2["value"]);
                }
            }
            
            $sql2 = "SELECT ROUND(AVG(value), 1) as avg FROM tempLog WHERE 
sensorid='" . $row["id"] . "'";
            
            $result2 = $conn->query($sql2);
            
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    array_push($column1texts, "Average");
                    array_push($column2texts, "");
                    array_push($column3texts, $row2["avg"]);
                }
            }
            
            table3columns($column1texts, $column2texts, $column3texts);
            echo "</th>";
        }
        echo "</tr>" . "\n";
        echo "</table>" . "\n";
    } else {
        echo "0 results";
    }
    
    mysqli_close($conn);

?>
</body>
</html>

