 <?php
    include('config.php');
    include('functions/getSql.function.php');

    $selected = false;
    $i = 0;

    ///// catch attributes
    if (isset($_GET['time'])) {
        $timeSelection = $_GET['time'];
    }

    if (isset($_GET['table'])) {
        $table = $_GET['table'];
    } else {
        $table = "powerLog";
    }

    if (isset($_GET['groupBy'])) {
        print "Grouped by: " . $_GET['groupBy'] . "<br>\n";
        $answer = create_selection($_GET['groupBy']);
        $groupby = $answer[0];
        $groupedby = $answer[1];
        $selection = $answer[2];
    } else {
        $groupby = "";
        $groupedby = "";
        $selection = "*";
    }

    if (isset($_GET['values'])) {
        print "Values: " . $_GET['values'] . "<br>\n";
    }

    $answer = getSQL($table, $selection, $groupby);

    $sql = $answer[0];
    $selection = $answer[1];



    print "SQL: " . $sql . "<br>\n";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $i++;
        }
    }

    print "<br>\nSelecting " . $selection;
    if (isset($_GET['groupBy'])) {
        print ", grouped by " . $_GET['groupBy'] . ",";
    }
    print " will give " . $i . " rows<br>\n";
    //return $i;

    ?> 
 