<html>
<head>
<title>JS Temperature</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<body>
<h1><center>JS Temperature</center></h1>
<center>- part of pi-heating</center>
<br>

<?php
    include ('config.php');
    include ('functions/functions.php');
    
    //var_dump($dallasTemps);
    
    $numberOfTemps = 0;
    $dallasId = "";
    $temperature = 0;
    
    
    $sql = "SELECT * FROM sensors";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. "<br>\n";
            echo "ip: " . $row["ip"]. "<br>\n";
            echo "ref: " . $row["ref"]. "<br>\n";
            echo "name: " . $row["name"]. "<br>\n";
            echo "value: " . $row["value"]. " ". $row["unit"]. "<br>\n";
            echo "<br>\n";
        }
    } else {
        echo "0 results";
    }
    
    mysqli_close($conn);

?>

</body>
</html>

