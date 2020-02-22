<?php
header('Content-type: text/plain');
echo date("d.m.Y-H:i:s") . " Event = " . $_GET['event'] . "\n";

$connect = mysqli_connect("localhost", "arduino", "arduinopass");
if (!$connect)
  {
  die('Could not connect: ' . mysqli_error());
  }

mysqli_select_db("arduino1", $connect);


mysqli_query("INSERT INTO eventLog (event)
VALUES (
'" . $_GET['event'] . "')");

mysqli_close($connect);
?>
