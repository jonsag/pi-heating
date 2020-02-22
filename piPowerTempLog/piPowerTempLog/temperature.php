<html>
<head>
<title>JS Temperature</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<body>
<h1><center>JS Temperature</center></h1>
<center>- part of jsPowerTempLog</center>
<br>

<?php
include ('config.php');
include ('functions/functions.php');

//var_dump($dallasTemps);

$numberOfTemps = 0;
$dallasId = "";
$temperature = 0;

// connect to mysql
if (!$db_con) {
  die('Could not connect: ' . mysqli_error());
}

// select database
mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));

$sql = "SELECT * FROM 1wireDevices WHERE deviceType='temp'";

$query = mysqli_query($db_con, $sql);

while($row = mysqli_fetch_array($query)) {
  $dallasInfo = file_get_contents('/sys/bus/w1/devices/'. $row['devicePath'] . '/w1_slave');
  $dallasId = substr( $dallasInfo, 0,strrpos( $dallasInfo, ':' ) );
  $temperature = (substr( $dallasInfo, strrpos( $dallasInfo, '=' )+1 )) / 1000;
  echo "Temperature sensor " . $numberOfTemps . ": " . $temperature . " C \t Id: " . $dallasId . "\t Place: " . $row['place'];
  $numberOfTemps++;
  lf();
}

// close connection to mysql                                                                                                                                                    
mysqli_close($db_con);

?>

</body>
</html>
