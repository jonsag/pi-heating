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
  die('Could not connect: ' . mysqli_error());
}

///// choose database
mysqli_select_db($db_name) or die(mysqli_error());

$query = mysqli_query($query);

while($row = mysqli_fetch_array( $query )) 
  { 
    $i++;
  } 

Print "Selecting " . $selection . " will give " . $i . " rows.";
//return $i;

 ?> 
