<?php

function getSQL($table, $selection, $groupby)
{
    $selected = false;
    
    if (!isset($sql)) {
        $sql = "start_value";
    }
    
    // /// last number of months, days, hours
    if (isset($_GET['years'])) {
        $selected = true;
        $years = $_GET['years'];
        $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $years YEAR) <= ts " . $groupby;
        $selection = "last " . $years . " years";
    }
    
    if (isset($_GET['months'])) {
        $selected = true;
        $months = $_GET['months'];
        $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $months MONTH) <= ts " . $groupby;
        $selection = "last " . $months . " months";
    }
    
    if (isset($_GET['weeks'])) {
        $selected = true;
        $weeks = $_GET['weeks'];
        $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $weeks WEEK) <= ts " . $groupby;
        $selection = "last " . $weeks . " weeks";
    }
    
    if (isset($_GET['days'])) {
        $selected = true;
        $days = $_GET['days'];
        $sql = "SELECT $selection FROM $table WHERE DATE_SUB(CURDATE(),INTERVAL $days DAY) <= ts " . $groupby;
        $selection = "last " . $days . " days";
    }
    
    if (isset($_GET['hours'])) {
        $selected = true;
        $hours = $_GET['hours'];
        $sql = "SELECT $selection FROM $table WHERE DATE_SUB(NOW(),INTERVAL $hours HOUR) <= ts " . $groupby;
        $selection = "last " . $hours . " hours";
    }
    
    // /// this year month, week, yesterday
    if (isset($_GET['this'])) {
        $selected = true;
        if ($_GET['this'] == "year") {
            $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE()) " . $groupby;
            $selection = "this year";
        }
        if ($_GET['this'] == "month") {
            $sql = "SELECT $selection FROM $table WHERE MONTH(ts) = MONTH(CURDATE()) " . $groupby;
            $selection = "this month";
        }
        if ($_GET['this'] == "week") {
            $sql = "SELECT $selection FROM $table WHERE WEEK(ts) = WEEK(CURDATE()) " . $groupby;
            $selection = "this week";
        }
        if ($_GET['this'] == "day") {
            $sql = "SELECT $selection FROM $table WHERE DATE(ts) = CURDATE() " . $groupby;
            $selection = "today";
        }
    }
    
    // /// last year month, week, yesterday
    if (isset($_GET['last'])) {
        $selected = true;
        if ($_GET['last'] == "year") {
            $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE()) - 1 " . $groupby;
            $selection = "last year";
        }
        if ($_GET['last'] == "month") {
            // $sql = "SELECT $selection FROM $table WHERE MONTH(ts) = MONTH(CURDATE()) - 1 " . $groupby;
            $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE() - INTERVAL 1 MONTH) AND MONTH(ts) = MONTH(CURDATE() - INTERVAL 1 MONTH)" . $groupby;
            // $sql = "SELECT $selection FROM $table WHERE YEARMONTH(ts) = YEARMONTH(NOW() - INTERVAL 1 MONTH)" . $groupby;
            $selection = "last month";
        }
        if ($_GET['last'] == "week") {
            // $sql = "SELECT $selection FROM $table WHERE WEEK(ts) = WEEK(CURDATE()) - 1 " . $groupby;
            // $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE() - INTERVAL 1 WEEK) AND WEEK(ts, 1) = WEEK(CURDATE() - INTERVAL 1 WEEK)" . $groupby;
            $sql = "SELECT $selection FROM $table WHERE YEARWEEK(ts) = YEARWEEK(NOW() - INTERVAL 1 WEEK)" . $groupby;
            $selection = "last week";
        }
        if ($_GET['last'] == "day") {
            // $sql = "SELECT $selection FROM $table WHERE DATE(ts) = CURDATE() - 1 " . $groupby;
            $sql = "SELECT $selection FROM $table WHERE YEAR(ts) = YEAR(CURDATE() - INTERVAL 1 DAY) AND DAY(ts) = DAY(CURDATE() - INTERVAL 1 DAY)" . $groupby;
            $selection = "yesterday";
        }
    }
    
    // /// date interval
    if (isset($_GET['start']) && isset($_GET['end'])) {
        $selected = true;
        $start = $_GET['start'];
        $end = $_GET['end'];
        $sql = "SELECT $selection FROM $table WHERE DATE(ts) BETWEEN '$start' AND '$end' " . $groupby;
        $selection = "between " . $start . " and " . $end . "";
    }
    
    // /// if nothing selected above
    if (! $selected) {
        $sql = "SELECT $selection FROM $table " . $groupby;
        $selection = "since start";
    }
    
    Print "Selection: " . $selection . "<br>\n";
    
    $answer[0] = $sql;
    $answer[1] = $selection;
    
    return ($answer);
}

function create_selection($groupBy)
{
    $answer = [];
    
    if ($_GET['groupBy'] == "hour") {
        $groupby = " GROUP BY DATE(ts), HOUR(ts)";
        $groupedby = "hour";
        $selection = "DATE_FORMAT(ts, '%Y-%m-%d %H:%i') AS ts";
    } else if ($_GET['groupBy'] == "day") {
        $groupby = " GROUP BY DATE(ts)";
        $groupedby = "day";
        $selection = "DATE_FORMAT(ts, '%Y-%m-%d') AS ts";
    } else if ($_GET['groupBy'] == "week") {
        $groupby = " GROUP BY YEAR(ts), WEEK(ts)";
        $groupedby = "week";
        $selection = "DATE_FORMAT(ts, '%Y-%m-%d') AS ts";
    } else if ($_GET['groupBy'] == "month") {
        $groupby = " GROUP BY YEAR(ts), MONTH(ts)";
        $groupedby = "month";
        $selection = "DATE_FORMAT(ts, '%Y-%m') AS ts";
    } else if ($_GET['groupBy'] == "year") {
        $groupby = " GROUP BY YEAR(ts)";
        $groupedby = "year";
        $selection = "DATE_FORMAT(ts, '%Y') AS ts";
    }
    
    $answer[0] = $groupby;
    $answer[1] = $groupedby;
    $answer[2] = $selection;
    
    return $answer;
}

function getFormattedSQL($sql_raw)
{
    if (empty($sql_raw) || ! is_string($sql_raw)) {
        return false;
    }
    
    $sql_reserved_all = array(
        'ACCESSIBLE',
        'ACTION',
        'ADD',
        'AFTER',
        'AGAINST',
        'AGGREGATE',
        'ALGORITHM',
        'ALL',
        'ALTER',
        'ANALYSE',
        'ANALYZE',
        'AND',
        'AS',
        'ASC',
        'AUTOCOMMIT',
        'AUTO_INCREMENT',
        'AVG_ROW_LENGTH',
        'BACKUP',
        'BEGIN',
        'BETWEEN',
        'BINLOG',
        'BOTH',
        'BY',
        'CASCADE',
        'CASE',
        'CHANGE',
        'CHANGED',
        'CHARSET',
        'CHECK',
        'CHECKSUM',
        'COLLATE',
        'COLLATION',
        'COLUMN',
        'COLUMNS',
        'COMMENT',
        'COMMIT',
        'COMMITTED',
        'COMPRESSED',
        'CONCURRENT',
        'CONSTRAINT',
        'CONTAINS',
        'CONVERT',
        'CREATE',
        'CROSS',
        'CURRENT_TIMESTAMP',
        'DATABASE',
        'DATABASES',
        'DAY',
        'DAY_HOUR',
        'DAY_MINUTE',
        'DAY_SECOND',
        'DEFINER',
        'DELAYED',
        'DELAY_KEY_WRITE',
        'DELETE',
        'DESC',
        'DESCRIBE',
        'DETERMINISTIC',
        'DISTINCT',
        'DISTINCTROW',
        'DIV',
        'DO',
        'DROP',
        'DUMPFILE',
        'DUPLICATE',
        'DYNAMIC',
        'ELSE',
        'ENCLOSED',
        'END',
        'ENGINE',
        'ENGINES',
        'ESCAPE',
        'ESCAPED',
        'EVENTS',
        'EXECUTE',
        'EXISTS',
        'EXPLAIN',
        'EXTENDED',
        'FAST',
        'FIELDS',
        'FILE',
        'FIRST',
        'FIXED',
        'FLUSH',
        'FOR',
        'FORCE',
        'FOREIGN',
        'FROM',
        'FULL',
        'FULLTEXT',
        'FUNCTION',
        'GEMINI',
        'GEMINI_SPIN_RETRIES',
        'GLOBAL',
        'GRANT',
        'GRANTS',
        'GROUP',
        'HAVING',
        'HEAP',
        'HIGH_PRIORITY',
        'HOSTS',
        'HOUR',
        'HOUR_MINUTE',
        'HOUR_SECOND',
        'IDENTIFIED',
        'IF',
        'IGNORE',
        'IN',
        'INDEX',
        'INDEXES',
        'INFILE',
        'INNER',
        'INSERT',
        'INSERT_ID',
        'INSERT_METHOD',
        'INTERVAL',
        'INTO',
        'INVOKER',
        'IS',
        'ISOLATION',
        'JOIN',
        'KEY',
        'KEYS',
        'KILL',
        'LAST_INSERT_ID',
        'LEADING',
        'LEFT',
        'LEVEL',
        'LIKE',
        'LIMIT',
        'LINEAR',
        'LINES',
        'LOAD',
        'LOCAL',
        'LOCK',
        'LOCKS',
        'LOGS',
        'LOW_PRIORITY',
        'MARIA',
        'MASTER',
        'MASTER_CONNECT_RETRY',
        'MASTER_HOST',
        'MASTER_LOG_FILE',
        'MASTER_LOG_POS',
        'MASTER_PASSWORD',
        'MASTER_PORT',
        'MASTER_USER',
        'MATCH',
        'MAX_CONNECTIONS_PER_HOUR',
        'MAX_QUERIES_PER_HOUR',
        'MAX_ROWS',
        'MAX_UPDATES_PER_HOUR',
        'MAX_USER_CONNECTIONS',
        'MEDIUM',
        'MERGE',
        'MINUTE',
        'MINUTE_SECOND',
        'MIN_ROWS',
        'MODE',
        'MODIFY',
        'MONTH',
        'MRG_MYISAM',
        'MYISAM',
        'NAMES',
        'NATURAL',
        'NOT',
        'NULL',
        'OFFSET',
        'ON',
        'OPEN',
        'OPTIMIZE',
        'OPTION',
        'OPTIONALLY',
        'OR',
        'ORDER',
        'OUTER',
        'OUTFILE',
        'PACK_KEYS',
        'PAGE',
        'PARTIAL',
        'PARTITION',
        'PARTITIONS',
        'PASSWORD',
        'PRIMARY',
        'PRIVILEGES',
        'PROCEDURE',
        'PROCESS',
        'PROCESSLIST',
        'PURGE',
        'QUICK',
        'RAID0',
        'RAID_CHUNKS',
        'RAID_CHUNKSIZE',
        'RAID_TYPE',
        'RANGE',
        'READ',
        'READ_ONLY',
        'READ_WRITE',
        'REFERENCES',
        'REGEXP',
        'RELOAD',
        'RENAME',
        'REPAIR',
        'REPEATABLE',
        'REPLACE',
        'REPLICATION',
        'RESET',
        'RESTORE',
        'RESTRICT',
        'RETURN',
        'RETURNS',
        'REVOKE',
        'RIGHT',
        'RLIKE',
        'ROLLBACK',
        'ROW',
        'ROWS',
        'ROW_FORMAT',
        'SECOND',
        'SECURITY',
        'SELECT',
        'SEPARATOR',
        'SERIALIZABLE',
        'SESSION',
        'SET',
        'SHARE',
        'SHOW',
        'SHUTDOWN',
        'SLAVE',
        'SONAME',
        'SOUNDS',
        'SQL',
        'SQL_AUTO_IS_NULL',
        'SQL_BIG_RESULT',
        'SQL_BIG_SELECTS',
        'SQL_BIG_TABLES',
        'SQL_BUFFER_RESULT',
        'SQL_CACHE',
        'SQL_CALC_FOUND_ROWS',
        'SQL_LOG_BIN',
        'SQL_LOG_OFF',
        'SQL_LOG_UPDATE',
        'SQL_LOW_PRIORITY_UPDATES',
        'SQL_MAX_JOIN_SIZE',
        'SQL_NO_CACHE',
        'SQL_QUOTE_SHOW_CREATE',
        'SQL_SAFE_UPDATES',
        'SQL_SELECT_LIMIT',
        'SQL_SLAVE_SKIP_COUNTER',
        'SQL_SMALL_RESULT',
        'SQL_WARNINGS',
        'START',
        'STARTING',
        'STATUS',
        'STOP',
        'STORAGE',
        'STRAIGHT_JOIN',
        'STRING',
        'STRIPED',
        'SUPER',
        'TABLE',
        'TABLES',
        'TEMPORARY',
        'TERMINATED',
        'THEN',
        'TO',
        'TRAILING',
        'TRANSACTIONAL',
        'TRUNCATE',
        'TYPE',
        'TYPES',
        'UNCOMMITTED',
        'UNION',
        'UNIQUE',
        'UNLOCK',
        'UPDATE',
        'USAGE',
        'USE',
        'USING',
        'VALUES',
        'VARIABLES',
        'VIEW',
        'WHEN',
        'WHERE',
        'WITH',
        'WORK',
        'WRITE',
        'XOR',
        'YEAR_MONTH'
    );
    
    $sql_skip_reserved_words = array(
        'AS',
        'ON',
        'USING'
    );
    $sql_special_reserved_words = array(
        '(',
        ')'
    );
    
    $sql_raw = str_replace("\n", " ", $sql_raw);
    
    $sql_formatted = "";
    
    $prev_word = "";
    $word = "";
    
    for ($i = 0, $j = strlen($sql_raw); $i < $j; $i ++) {
        $word .= $sql_raw[$i];
        
        $word_trimmed = trim($word);
        
        if ($sql_raw[$i] == " " || in_array($sql_raw[$i], $sql_special_reserved_words)) {
            $word_trimmed = trim($word);
            
            $trimmed_special = false;
            
            if (in_array($sql_raw[$i], $sql_special_reserved_words)) {
                $word_trimmed = substr($word_trimmed, 0, - 1);
                $trimmed_special = true;
            }
            
            $word_trimmed = strtoupper($word_trimmed);
            
            if (in_array($word_trimmed, $sql_reserved_all) && ! in_array($word_trimmed, $sql_skip_reserved_words)) {
                if (in_array($prev_word, $sql_reserved_all)) {
                    $sql_formatted .= '<b>' . strtoupper(trim($word)) . '</b>' . '&nbsp;';
                } else {
                    $sql_formatted .= '<br/>&nbsp;';
                    $sql_formatted .= '<b>' . strtoupper(trim($word)) . '</b>' . '&nbsp;';
                }
                
                $prev_word = $word_trimmed;
                $word = "";
            } else {
                $sql_formatted .= trim($word) . '&nbsp;';
                
                $prev_word = $word_trimmed;
                $word = "";
            }
        }
    }
    
    $sql_formatted .= trim($word);
    
    return $sql_formatted;
}

?>
