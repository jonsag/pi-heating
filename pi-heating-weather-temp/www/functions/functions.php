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
?>
