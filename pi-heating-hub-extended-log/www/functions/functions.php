<?php

function lf() {
  if (is_apache()) {
    echo "<br>\n";
  }
  else {
    echo "\n";
  }
}


function dlf() {
  if (is_apache()) {
  echo "<br>\n<br>\n";
  }
  else {
    echo "\n\n";
  }
}

function nl() {
  echo "\n";
}

function is_apache() {
  if (PHP_SAPI == "apache2handler") {
    return (1);
  }
}

function is_cli() {
  if (PHP_SAPI == "cli") {
    return (1);
  }
}

function table3columns($column1texts, $column2texts, $column3texts) {
    $cellpadding = 0;
    $cellspacing = 10;
    $columns = 3;
    $rows = sizeof($column1texts);    
    
    echo "<table cellpadding=" . $cellpadding . " cellspacing=" . $cellspacing . ">\n";
    for ($row = 0; $row <= ($rows - 1); $row++) {
        echo "<tr>" . "\n";
        
        $text =  [ $column1texts[$row],
            $column2texts[$row],
            $column3texts[$row]
        ];
        
        for ($column = 0; $column <= ($columns - 1); $column++) {
            echo "<th>" . $text[$column] . "</th>" . "\n";
        }
        
        echo "</tr>" . "\n";
    }
    echo "</table>" . "\n";
    
}
?>
