<html>
<head>
<title>JS Chill Factor</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<body>
<h1><center>JS Chill Factor</center></h1>
<center>- part of jsPowerTempLog</center>
<br>

<?php

include ('config.php');
include ('functions/functions.php');

include ('functions/getSql.function.php');

$table = "tempLog";

$answer = getSQL($table, $_GET);

///// connect to database
if (!$db_con) {
  die('Could not connect: ' . mysqli_error());
}

///// choose database
mysqli_select_db($db_con, $db_name) or die(mysqli_error($db_con));

$sql = "SELECT id FROM 1wireDevices WHERE place='ute'";

$result = mysqli_query($db_con, $sql);

if ($result) {
  $id = (mysqli_result($result,0));
}
else {
  die('Invalid query: ' . mysqli_error());
}

$query = mysqli_query($db_con, $answer[0]);

Print "<table border cellpadding=3>";
Print "<tr><td colspan=18>" . $table . " " . $answer[1];
lf();
Print "sql=" . $answer[0] . "<td></tr>\n";
Print "<tr>";
Print "<th>Time</th><th>outdoor temp</th><th>wind</th><th>chill factor</th></tr>\n";
while($tempRow = mysqli_fetch_array( $query ))
  {
    Print "<tr>";
    Print "<td>".$tempRow['ts'] . "</td> ";
    $outdoorTemp = $tempRow[1 + $id];
    Print "<td>".$outdoorTemp . "</td>";

    $time = substr($tempRow['ts'], 0, -3);
    $sql = "SELECT averageWindSpeed FROM `weatherLog` WHERE `ts` LIKE '{$time}%'";
    $result = mysqli_query($sql);
    if ($result) {
      $averageWindSpeed = (mysqli_result($result,0));
    }
    else {
      die('Invalid query: ' . mysqli_error());
    }
    Print "<td>".$averageWindSpeed . "</td>";

    if (empty($averageWindSpeed)) {
      $chillFactor = "NA";
    }
    else {
      $chillFactor = round((13.12 + 0.6215 * $outdoorTemp - 13.956 * pow($averageWindSpeed, 0.16) + 0.48669 * $outdoorTemp * pow($averageWindSpeed, 0.16)), 2, PHP_ROUND_HALF_UP); 
    }
    Print "<td>".$chillFactor . "</td>";
    Print "</tr>\n";

    if (is_apache()) {
      flush();
      ob_flush();
    }

  }
Print "</table>";

// close connection to mysql
mysqli_close($db_con);

?>

</body>
</html>
