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
Print "<th>Timestamp</th><th>Temp 0</th><th>Temp 1</th><th>Temp 2</th><th>Temp 3</th><th>Temp 4</th><th>Temp 5</th><th>Temp 6</th><th>Temp 7</th><th>Temp 8</th><th>Temp 9</th><th>Temp 10</th><th>Event</th></tr>\n";
while($row = mysqli_fetch_array( $query )) 
  { 
    Print "<tr>"; 
    Print "<td>".$row['ts'] . "</td> "; 
    Print "<td>".$row['temp0'] . "</td>";
    Print "<td>".$row['temp1'] . "</td>";
    Print "<td>".$row['temp2'] . "</td>";
    Print "<td>".$row['temp3'] . "</td>";
    Print "<td>".$row['temp4'] . "</td>";
    Print "<td>".$row['temp5'] . "</td>";
    Print "<td>".$row['temp6'] . "</td>";
    Print "<td>".$row['temp7'] . "</td>";
    Print "<td>".$row['temp8'] . "</td>";
    Print "<td>".$row['temp9'] . "</td>";
    Print "<td>".$row['temp10'] . "</td>";
    Print "<td>".$row['event'] . "</td>";
    Print "</tr>\n";
  } 
Print "</table>"; 

// close connection to mysql
mysqli_close($db_con);

 ?> 
