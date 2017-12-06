 <?php 
include ("config.php");
include ('functions/functions.php');

include ('getSql.php');

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

$query = mysql_query($sql);

Print "<table border cellpadding=3>";
Print "<tr><td colspan=18>" . $table . " " . $selection;
lf();
Print "sql=" . $sql . "<td></tr>\n";
Print "<tr>";
Print "<th>Timestamp</th><th>Wind dir</th><th>Wind dir value</th><th>Avg wind dir value</th><th>Wind speed</th><th>Avg wind speed</th><th>Rain since last</th><th>Temp</th><th>Event</th></tr>\n";
while($row = mysql_fetch_array( $query )) 
  { 
    Print "<tr>"; 
    Print "<td>".$row['ts'] . "</td> "; 
    Print "<td>".$row['windDirection'] . "</td>";
    Print "<td>".$row['windDirectionValue'] . "</td>";
    Print "<td>".$row['averageWindDirectionValue'] . "</td>";
    Print "<td>".$row['windSpeed'] . "</td>";
    Print "<td>".$row['averageWindSpeed'] . "</td>";
    Print "<td>".$row['rainSinceLast'] . "</td>";
    Print "<td>".$row['temp'] . "</td>";
    Print "<td>".$row['event'] . "</td>";
    Print "</tr>\n";
  } 
Print "</table>"; 

// close connection to mysql
mysql_close($db_con);

?> 
