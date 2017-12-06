<?php
///// config file
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
mysql_select_db($db_name)
or die(mysql_error());

$query = mysql_query($query);

$fp = fopen('data.csv', "w");

// fetch a row and write the column names out to the file
$row = mysql_fetch_assoc($query);
$line = "";
$comma = "";
foreach($row as $name => $value) {
  $line .= $comma . '"' . str_replace('"', '""', $name) . '"';
  $comma = ",";
}
$line .= "\n";
fputs($fp, $line);

// remove the result pointer back to the start
mysql_data_seek($query, 0);

// and loop through the actual data
while($row = mysql_fetch_assoc($query)) {
  
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

?>