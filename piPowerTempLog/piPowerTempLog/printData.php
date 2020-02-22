 <?php 
include ("config.php");
include ('getQuery.php');

$selected = false;

///// catch attributes
if (isset($_GET['time'])) {
  $timeSelection = $_GET['time'];
}

///// connect to database
if (!$db_con) {
  die('Could not connect: ' . mysql_error());
}

///// choose database
mysql_select_db($db_name) or die(mysql_error());

$query = mysql_query($query);

Print "<table border cellpadding=3>";
Print "<tr><td colspan=18>pulseLog " . $selection . "<td></tr>\n";
Print "<tr>";
Print "<th>Timestamp</th><th>Current time</th><th>Diff time</th><th>Unix time</th><th>Current R1</th><th>Current S2</th><th>Current T3</th><th>Avg Current R1</th><th>Avg Current S2</th><th>Avg Current T3</th><th>Temp 0</th><th>Temp 1</th><th>Temp 2</th><th>Temp 3</th><th>Temp 4</th><th>Temp 5</th><th>Pulses</th><th>Event</th></tr>\n";
while($row = mysql_fetch_array( $query )) 
  { 
    Print "<tr>"; 
    Print "<td>".$row['timeStamp'] . "</td> "; 
    Print "<td>".$row['currentTime'] . "</td>";
    Print "<td>".$row['timeDiff'] . "</td>";
    Print "<td>".$row['unixTime'] . "</td>"; 
    Print "<td>".$row['currentR1'] . "</td>";
    Print "<td>".$row['currentS2'] . "</td>";
    Print "<td>".$row['currentT3'] . "</td>";
    Print "<td>".$row['currentAverageR1'] . "</td>";
    Print "<td>".$row['currentAverageS2'] . "</td>";
    Print "<td>".$row['currentAverageT3'] . "</td>";
    Print "<td>".$row['temp0'] . "</td>";
    Print "<td>".$row['temp1'] . "</td>";
    Print "<td>".$row['temp2'] . "</td>";
    Print "<td>".$row['temp3'] . "</td>";
    Print "<td>".$row['temp4'] . "</td>";
    Print "<td>".$row['temp5'] . "</td>";
    Print "<td>".$row['pulses'] . "</td>";
    Print "<td>".$row['event'] . "</td>";
    Print "</tr>\n";
  } 
Print "</table>"; 
 ?> 
