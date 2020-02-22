 <?php
include ('config.php');
include ('getSql.php');

$selected = false;
$i = 0;
$query = "";

// /// catch attributes
if (isset($_GET['time'])) {
    $timeSelection = $_GET['time'];
}

// /// connect to database
if (! $db_con) {
    die('Could not connect: ' . mysqli_error());
}

// /// choose database
mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));

$query = mysqli_query($db_con, $sql);

while ($row = mysqli_fetch_array($query)) {
    $i ++;
}

Print "<br>SQL: " . $sql;
Print "<br>";
Print "<br>Selecting " . $selection . " will give " . $i . " rows";
// return $i;

?> 
