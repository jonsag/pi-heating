#!/bin/bash

#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/weatherPoller.php 0 1 cron > /dev/null 2>&1

php /var/www/piHeatingHub-extended-log/weatherPoller.php 0 1 cron

