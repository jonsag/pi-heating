#!/bin/bash

php /var/www/piPowerTempLog/tempPoller.php 0 1 cron
php /var/www/piPowerTempLog/powerPoller.php 0 1 cron
