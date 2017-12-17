#!/bin/bash

#python /home/pi/pi-heating-hub/cron/poll-sensors.py
#python /home/pi/pi-heating-hub/cron/update-timers.py
#python /home/pi/pi-heating-hub/cron/scan-network.py
#python /home/pi/pi-heating-hub/cron/process-schedules.py
#python /home/pi/pi-heating-hub/cron/activate-devices.py

#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/powerPoller.php 0 1 cron > /dev/null 2>&1
#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/tempPoller.php 0 1 cron > /dev/null 2>&1
#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/weatherPoller.php 0 1 cron > /dev/null 2>&1

php /var/www/pi-heating-hub-extended-log/tempPoller.php 0 1 cron
php /var/www/pi-heating-hub-extended-log/powerPoller.php 0 1 cron
