<?php
///// config file
include ('config.php');
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
mysqli_select_db($db_name)
or die(mysqli_error());

$query = mysqli_query($sql);

$fp = fopen('data.csv', "w");

// fetch a row and write the column names out to the file
$row = mysqli_fetch_assoc($query);
$line = "";
$comma = "";
foreach($row as $name => $value) {
  $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
  $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
mysqli_data_seek($query, 0);

// and loop through the actual data
while($row = mysqli_fetch_assoc($query)) {
  
  $line = "";
  $comma = "";
  foreach($row as $value) {
    $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
    $comma = ",";
  }
  $line .= "\n";
  fputs($fp, $line);
}


$file = file_get_contents('data.csv');
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="csvData-' . $selection . '.csv"');
header('Content-Length: ' . strlen($file));
echo $file;

fclose($fp);

// close connection to mysql
mysqli_close($db_con);

?>
