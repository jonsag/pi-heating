#!/bin/bash

#python /home/pi/piHeatingHub/cron/poll-sensors.py
#python /home/pi/piHeatingHub/cron/update-timers.py
#python /home/pi/piHeatingHub/cron/scan-network.py
#python /home/pi/piHeatingHub/cron/process-schedules.py
#python /home/pi/piHeatingHub/cron/activate-devices.py

#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/powerPoller.php 0 1 cron > /dev/null 2>&1
#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/tempPoller.php 0 1 cron > /dev/null 2>&1
#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/weatherPoller.php 0 1 cron > /dev/null 2>&1

php /var/www/html/piHeatingHubExtendedLog/tempPoller.php 0 1 cron
php /var/www/html/piHeatingHubExtendedLog/powerPoller.php 0 1 cron
