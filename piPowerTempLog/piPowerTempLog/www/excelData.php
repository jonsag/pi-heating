<?php
    ///// config file
    include ("config.php");
    include ('functions/functions.php');
    include ('functions/getSql.function.php');
    
    $selected = false;
        
    ///// catch attributes
    if (isset($_GET['time'])) {
        $timeSelection = $_GET['time'];
    }
    
    if (isset($_GET['table'])) {
        $table = $_GET['table'];
    }
    
    // find sensor ids
    $sql = "SELECT id FROM sensors";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sensorids = [];
        $i = 0;
        //echo "['Time'";
        while($row = $result->fetch_assoc()) {
            ++$i;
            $sensorids[$i] = $row['id'];
        }
    }
    
    // create selection
    $selection = "ts";
    $i = 0;
    foreach ($sensorids as $sensorid) {
        $selection .= ", ROUND(MAX(CASE WHEN sensorid = " . $sensorid . " THEN value ELSE null END), 1) AS sensor" . $sensorid;
    }
    
    $condition = "";
    $groupby = "GROUP BY ts";
    
    $answer = getSQL($table, $selection, $groupby);
    
    $sql = $answer[0];
    $selection = $answer[1];
    
    $query = $conn->query($sql);
    //$query = mysqli_query($conn, $sql);
    
    // first thing that we are going to do is make some functions for writing out
    // and excel file. These functions do some hex writing and to be honest I got
    // them from some where else but hey it works so I am not going to question it
    // just reuse
     
     
    // This one makes the beginning of the xls file
    function xlsBOF() {
      echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
      return;
    }
     
    // This one makes the end of the xls file
    function xlsEOF() {
      echo pack("ss", 0x0A, 0x00);
      return;
    }
     
    // this will write text in the cell you specify
    function xlsWriteLabel($Row, $Col, $Value ) {
      $L = strlen($Value);
      echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
      echo $Value;
      return;
    }
    
    
    // Ok now we are going to send some headers so that this
    // thing that we are going make comes out of browser
    // as an xls file.
    //
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
     
    //this line is important its makes the file name
    header("Content-Disposition: attachment;filename=excelData-" . $selection . ".xls ");
     
    header("Content-Transfer-Encoding: binary ");
     
    // start the file
    xlsBOF();
     
    // these will be used for keeping things in order.
    $col = 0;
    $row = 0;
     
    // This tells us that we are on the first row
    $first = true;
     
    //while( $qrow = mysqli_fetch_assoc( $query ) ) {
    while($qrow = $query->fetch_assoc()) {
        // Ok we are on the first row
        // lets make some headers of sorts
        if( $first )
          {
    	foreach( $qrow as $k => $v )
    	  {
    	    // take the key and make label
    	    // make it uppper case and replace _ with ' '
    	    xlsWriteLabel( $row, $col, strtoupper( ereg_replace( "_" , " " , $k ) ) );
    	    $col++;
    	  }
     
    	// prepare for the first real data row
    	$col = 0;
    	$row++;
    	$first = false;
          }
     
        // go through the data
        foreach( $qrow as $k => $v )
          {
    	// write it out
    	xlsWriteLabel( $row, $col, $v );
    	$col++;
          }
        // reset col and goto next row
        $col = 0;
        $row++;
      }
     
    xlsEOF();
    exit();
    
    // close connection to mysql
    mysqli_close($conn);;

?>
