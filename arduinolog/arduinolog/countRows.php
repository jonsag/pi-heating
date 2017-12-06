 <?php 
include ('config.php');
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

while($row = mysql_fetch_array( $query )) 
  { 
    $i++;
  } 

Print "Selecting " . $selection . " will give " . $i . " rows.";
//return $i;

 ?> 
