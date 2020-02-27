 <?php 
    include ('config.php');
    include ('functions/getSql.function.php');
    
    $selected = false;
    
    ///// catch attributes
    if (isset($_GET['time'])) {
      $timeSelection = $_GET['time'];
    }
        
    $answer = getSQL($table, $get);
    
    $sql = $answer[0];
    $selection = $answer[1];
    
    echo $sql;
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $i++;
        }
    }
    
    Print "Selecting " . $selection . " will give " . $i . " rows.";
    //return $i;

 ?> 
 