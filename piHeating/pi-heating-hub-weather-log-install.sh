#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-hub-weather-log' configuration script.

# Die on any errors

#set -e
clear


if [[ `whoami` != "root" ]]
then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi


OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"stretch"* ]]
then
  printf "\n\n EXITING : Script must be run on PI OS Stretch. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/pi-heating-hub/README.md" ]
then
  printf "\n\n First you must install pi-heating-hub. \n\n"
  exit 1
fi

printf "\n\n\n Please enter IP of pi-heating-weather : "
read WEATHER_IP
echo

curl -s --head http://$WEATHER_IP:8083/weather.php | sed -n 1p | grep 'HTTP/1.1 200 OK' > /dev/null

if [ $? -eq 0 ]
then
  echo "Hub exists"
else
  printf "\n\n First you must install pi-heating-weather. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/pi-heating-hub-weather-log/README.md" ]
then
  printf "\n\n Installing pi-heating-hub-weather-log ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/pi-heating-hub-weather-log" ]
  then
    rm -rf "/home/pi/pi-heating-hub-weather-log"
  fi

  mv "/home/pi/pi-heating/pi-heating-hub-weather-log" "/home/pi/pi-heating-hub-weather-log"
  #mv "/home/pi/pi-heating-hub-extended-log/www" "/var/www/pi-heating-hub-extended-log"
  
  chown -R pi:pi "/home/pi/pi-heating-hub-weather-log"
  chmod -R 750 "/home/pi/pi-heating-hub-weather-log"

  #chown -R pi:www-data "/var/www/pi-heating-hub-extended-log"
  #chmod -R 755 "/var/www/pi-heating-hub-extended-log"

  if [ ! -f "/home/pi/pi-heating-hub-weather-log/README.md" ]
    then
      printf "\n\n EXITING : pi-heating-hub-weather-log installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n pi-heating-hub-weather-log is already installed. \n"
fi

if [ ! -f "/etc/cron.d/pi-heating-hub-weather-log" ]
  then
    cat > /etc/cron.d/pi-heating-hub-weather-log <<CRON
*/2 * * * * pi /bin/bash /home/pi/pi-heating-hub-weather-log/cron/wrapper.sh
CRON
    service cron restart
fi


printf "\n\n Installing additional database tables ...\n"

DB_USER=$(cat /home/pi/pi-heating-hub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /home/pi/pi-heating-hub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /home/pi/pi-heating-hub/config/config.ini | grep database | awk '{print $3}')

mysql -u$DB_USER -p$DB_PASSWORD $DB<< DATABASE

CREATE TABLE IF NOT EXISTS weatherLog (
       id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
       ts TIMESTAMP,
       windDirection char(3),
       windDirectionValue FLOAT,
       averageWindDirectionValue FLOAT,
       windSpeed FLOAT,
       averageWindSpeed FLOAT,
       rainSinceLast FLOAT,
       event char(255),
       PRIMARY KEY (id)
) CHARACTER SET UTF8;;

DATABASE

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
