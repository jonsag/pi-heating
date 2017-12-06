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
 
while( $qrow = mysql_fetch_assoc( $query ) )
  {
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

?>