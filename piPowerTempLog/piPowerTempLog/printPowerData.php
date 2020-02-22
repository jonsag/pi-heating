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
  die('Could not connect: ' . mysqli_error());
}

///// choose database
mysqli_select_db($db_name) or die(mysqli_error());

$query = mysqli_query($sql);

Print "<table border cellpadding=3>";
Print "<tr><td colspan=18>" . $table . " " . $selection;
lf();
Print "sql=" . $sql . "<td></tr>\n";
Print "<tr>";
Print "<th>Timestamp</th><th>Current R1</th><th>Current S2</th><th>Current T3</th><th>Avg Current R1</th><th>Avg Current S2</th><th>Avg Current T3</th><th>Temp 0</th><th>Pulses</th><th>Event</th></tr>\n";
while($row = mysqli_fetch_array( $query )) 
  { 
    Print "<tr>"; 
    Print "<td>".$row['ts'] . "</td> "; 
    Print "<td>".$row['currentR1'] . "</td>";
    Print "<td>".$row['currentS2'] . "</td>";
    Print "<td>".$row['currentT3'] . "</td>";
    Print "<td>".$row['currentAverageR1'] . "</td>";
    Print "<td>".$row['currentAverageS2'] . "</td>";
    Print "<td>".$row['currentAverageT3'] . "</td>";
    Print "<td>".$row['temp'] . "</td>";
    Print "<td>".$row['pulses'] . "</td>";
    Print "<td>".$row['event'] . "</td>";
    Print "</tr>\n";
  } 
Print "</table>"; 

// close connection to mysql
mysqli_close($db_con);

 ?> 
