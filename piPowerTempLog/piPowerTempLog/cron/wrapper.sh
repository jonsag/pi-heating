#!/bin/bash

#python /home/pi/bin/piHeatingHub/cron/poll-sensors.py
#python /home/pi/bin/piHeatingHub/cron/update-timers.py
#python /home/pi/bin/piHeatingHub/cron/scan-network.py
#python /home/pi/bin/piHeatingHub/cron/process-schedules.py
#python /home/pi/bin/piHeatingHub/cron/activate-devices.py

#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/powerPoller.php 0 1 cron > /dev/null 2>&1
#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/tempPoller.php 0 1 cron > /dev/null 2>&1
#*/2 * * * * /usr/bin/php /var/www/jsPowerTempLog/weatherPoller.php 0 1 cron > /dev/null 2>&1

php /var/www/piPowerTempLog/tempPoller.php 0 1 cron
php /var/www/piPowerTempLog/powerPoller.php 0 1 cron
