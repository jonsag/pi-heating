<?php
header('Content-type: text/plain');
echo date("d.m.Y-H:i:s") . " Unix Time = " . $_GET['unixTime'] . "\n";
echo date("d.m.Y-H:i:s") . " Pulses = " . $_GET['pulses'] . "\n";
echo date("d.m.Y-H:i:s") . " Current R = " . $_GET['currentR'] . "\n";
echo date("d.m.Y-H:i:s") . " Current S = " . $_GET['currentS'] . "\n";
echo date("d.m.Y-H:i:s") . " Current T = " . $_GET['currentT'] . "\n";
echo date("d.m.Y-H:i:s") . " Temp 1 = " . $_GET['temp1'] . "\n";
echo date("d.m.Y-H:i:s") . " Temp 2 = " . $_GET['temp2'] . "\n";
echo date("d.m.Y-H:i:s") . " Temp 3 = " . $_GET['temp3'] . "\n";
echo date("d.m.Y-H:i:s") . " Event = " . $_GET['event'] . "\n";

$connect = mysql_connect("localhost", "arduino", "arduinopass");
if (!$connect)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("arduino1", $connect);


$query = "INSERT INTO pulseLog (unixTime, pulses, currentR, currentS, currentT, temp1, temp2, temp3, event)
VALUES (
'" . $_GET['unixTime'] . "',
'" . $_GET['pulses'] . "', 
'" . $_GET['currentR'] . "', 
'" . $_GET['currentS'] . "', 
'" . $_GET['currentT'] . "', 
'" . $_GET['temp1'] . "', 
'" . $_GET['temp2'] . "', 
'" . $_GET['temp3'] . "',
'" . $_GET['event'] . "')";

$result = mysql_query($query);

if ($result) {
echo "OK";
}
else {
die('Invalid query: ' . mysql_error());
}

mysql_close($connect);
?>
