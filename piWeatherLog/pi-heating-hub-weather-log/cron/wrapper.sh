#!/bin/bash

#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/weatherPoller.php 0 1 cron > /dev/null 2>&1

php /var/www/pi-heating-hub-extended-log/weatherPoller.php 0 1 cron

