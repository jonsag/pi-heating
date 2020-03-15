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
     } else {
         $table = "powerLog";
     }
    
     // create selection
     $selection = "ts, currentR1, currentS2 ,currentT3, currentAverageR1, currentAverageS2, currentAverageT3, pulses, event";
     
     if (isset($_GET['groupBy'])) {
         Print "Grouped by: " . $_GET['groupBy'] . "<br>\n";
         $answer = create_selection($_GET['groupBy']);
         $groupby = $answer[0];
         $groupedby = $answer[1];
         $selection = $answer[2];
     } else {
         $groupby = "";
         $groupedby = "";
         $selection = "*";
     }
     
     $answer = getSQL($table, $selection, $groupby);
     
     $sql = $answer[0];
     $selection = $answer[1];
     
     $query = $conn->query($sql);
    
    Print "<table border cellpadding=3>";
    Print "<tr><td colspan=18>" . $table . " " . $selection;
    lf();
    Print "sql=" . $sql . "</td></tr>\n";
    Print "<th>Timestamp</th><th>Current R1</th><th>Current S2</th><th>Current T3</th><th>Avg Current R1</th><th>Avg Current S2</th><th>Avg Current T3</th><th>Pulses</th><th>Event</th></tr>\n";
    while($row = $query->fetch_assoc()) { 
        Print "<tr>"; 
        Print "<td>".$row['ts'] . "</td> "; 
        Print "<td>".$row['currentR1'] . "</td>";
        Print "<td>".$row['currentS2'] . "</td>";
        Print "<td>".$row['currentT3'] . "</td>";
        Print "<td>".$row['currentAverageR1'] . "</td>";
        Print "<td>".$row['currentAverageS2'] . "</td>";
        Print "<td>".$row['currentAverageT3'] . "</td>";
        Print "<td>".$row['pulses'] . "</td>";
        Print "<td>".$row['event'] . "</td>";
        Print "</tr>\n";
    } 
    Print "</table>"; 
    
    // close connection to mysql
    mysqli_close($conn);

 ?> 
