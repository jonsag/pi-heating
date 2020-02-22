<?php
header('Content-type: text/plain');
echo date("d.m.Y-H:i:s") . " Event = " . $_GET['event'] . "\n";

$connect = mysql_connect("localhost", "arduino", "arduinopass");
if (!$connect)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("arduino1", $connect);


mysql_query("INSERT INTO eventLog (event)
VALUES (
'" . $_GET['event'] . "')");

mysql_close($connect);
?>
