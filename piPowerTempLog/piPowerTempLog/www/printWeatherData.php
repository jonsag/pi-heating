 <?php
  include("config.php");
  include('functions/functions.php');
  include('functions/getSql.function.php');

  $selected = false;

  ///// catch attributes
  if (isset($_GET['time'])) {
    $timeSelection = $_GET['time'];
  }

  if (isset($_GET['table'])) {
    $table = $_GET['table'];
  }

  // create selection
  $selection = "ts, windDirection, windDirectionValue ,averageWindDirectionValue, windSpeed, averageWindSpeed, rainSinceLast, event";

  $condition = "";
  $groupby = "";

  $answer = getSQL($table, $selection, $groupby);

  $sql = $answer[0];
  $selection = $answer[1];

  $query = $conn->query($sql);

  print "<table border cellpadding=3>";
  print "<tr><td colspan=18>" . $table . " " . $selection;
  lf();
  print "sql=" . $sql . "<td></tr>\n";
  print "<tr>";
  print "<th>Timestamp</th><th>Wind dir</th><th>Wind dir value</th><th>Avg wind dir value</th><th>Wind speed</th><th>Avg wind speed</th><th>Rain since last</th><th>Event</th></tr>\n";
  while ($row = $query->fetch_assoc()) {
    print "<tr>";
    print "<td>" . $row['ts'] . "</td> ";
    print "<td>" . $row['windDirection'] . "</td>";
    print "<td>" . $row['windDirectionValue'] . "</td>";
    print "<td>" . $row['averageWindDirectionValue'] . "</td>";
    print "<td>" . $row['windSpeed'] . "</td>";
    print "<td>" . $row['averageWindSpeed'] . "</td>";
    print "<td>" . $row['rainSinceLast'] . "</td>";
    print "<td>" . $row['event'] . "</td>";
    print "</tr>\n";
  }
  print "</table>";

  // close connection to mysql
  mysqli_close($conn);

  ?> 
