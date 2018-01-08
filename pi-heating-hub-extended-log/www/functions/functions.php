<?php

function lf()
{
    if (is_apache()) {
        echo "<br>\n";
    } else {
        echo "\n";
    }
}

function dlf()
{
    if (is_apache()) {
        echo "<br>\n<br>\n";
    } else {
        echo "\n\n";
    }
}

function nl()
{
    echo "\n";
}

function is_apache()
{
    if (PHP_SAPI == "apache2handler") {
        return (1);
    }
}

function is_cli()
{
    if (PHP_SAPI == "cli") {
        return (1);
    }
}

// function secondsToTime($seconds) {
// $dtF = new \DateTime('@0');
// $dtT = new \DateTime("@$seconds");
// return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
// }
function secondsToTime($inputSeconds)
{
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;
    
    // Extract days
    $days = floor($inputSeconds / $secondsInADay);
    
    // Extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);
    
    // Extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);
    
    // Extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
    
    // Format and return
    $timeParts = [];
    $sections = [
        'day' => (int) $days,
        'hour' => (int) $hours,
        'minute' => (int) $minutes,
        'second' => (int) $seconds
    ];
    
    foreach ($sections as $name => $value) {
        if ($value > 0) {
            $timeParts[] = $value . ' ' . $name . ($value == 1 ? '' : 's');
        }
    }
    
    return implode(', ', $timeParts);
}

function table3columns($column1texts, $column2texts, $column3texts)
{
    // $cellpadding = 0;
    // $cellspacing = 10;
    $columns = 3;
    
    // 4 values: top right bottom left
    // 3 values: top right/left bottom
    // 2 values: top/bottom right/left
    // 1 value: top/bottom/right/left
    $style = "padding: 5px 15px;";
    
    $rows = sizeof($column1texts);
    
    // echo "<table cellpadding=" . $cellpadding . " cellspacing=" . $cellspacing . ">\n";
    echo "<table style='" . $style . "'>\n";
    for ($row = 0; $row <= ($rows - 1); $row ++) {
        echo "<tr>" . "\n";
        
        $text = [
            $column1texts[$row],
            $column2texts[$row],
            $column3texts[$row]
        ];
        
        for ($column = 0; $column <= ($columns - 1); $column ++) {
            echo "<th>" . $text[$column] . "</th>" . "\n";
        }
        
        echo "</tr>" . "\n";
    }
    echo "</table>" . "\n";
}

function chartOptions1($minValue, $maxValue)
{
    echo "chartArea: {left:100,top:100,width:'80%',height:'60%'},\n";
    
    echo "hAxis: {\n";
    //echo "    title: 'Hello',\n";
    //echo "    titleTextStyle: {\n";
    //echo "    color: '#FF0000'\n";
    //echo "    },\n";
    echo "    gridlines: {color: '#FF0000', count: -1}\n";
    echo "},\n";

    echo "vAxis: {\n";
    echo "    gridlines: {count: -1},\n";
    echo "    baseline: 0,\n";
    echo "    minValue: " . $minValue . ",\n";
    echo "    maxValue: " . $maxValue . "\n";
    echo "},\n";
    
    echo "animation: {duration: 2000, easing: 'out', startup: true}\n";
}


?>
