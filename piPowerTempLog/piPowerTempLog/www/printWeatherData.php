 <?php 
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
     
     // create selection
     $selection = "ts, windDirection, windDirectionValue ,averageWindDirectionValue, windSpeed, averageWindSpeed, rainSinceLast, event";
     
     $condition = "";
     $groupby = "";
     
     $answer = getSQL($table, $selection, $groupby);
     
     $sql = $answer[0];
     $selection = $answer[1];
     
     $query = $conn->query($sql);
    
    Print "<table border cellpadding=3>";
    Print "<tr><td colspan=18>" . $table . " " . $selection;
    lf();
    Print "sql=" . $sql . "<td></tr>\n";
    Print "<tr>";
    Print "<th>Timestamp</th><th>Wind dir</th><th>Wind dir value</th><th>Avg wind dir value</th><th>Wind speed</th><th>Avg wind speed</th><th>Rain since last</th><th>Event</th></tr>\n";
    while($row = $query->fetch_assoc()) 
      { 
        Print "<tr>"; 
        Print "<td>".$row['ts'] . "</td> "; 
        Print "<td>".$row['windDirection'] . "</td>";
        Print "<td>".$row['windDirectionValue'] . "</td>";
        Print "<td>".$row['averageWindDirectionValue'] . "</td>";
        Print "<td>".$row['windSpeed'] . "</td>";
        Print "<td>".$row['averageWindSpeed'] . "</td>";
        Print "<td>".$row['rainSinceLast'] . "</td>";
        Print "<td>".$row['event'] . "</td>";
        Print "</tr>\n";
      } 
    Print "</table>"; 
    
    // close connection to mysql
    mysqli_close($conn);

?> 
