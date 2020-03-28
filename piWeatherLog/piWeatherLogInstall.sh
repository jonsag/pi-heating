#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-weather' configuration script.

# Die on any errors

#set -e
clear


if [[ `whoami` != "root" ]]
then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi


OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"buster"* ]]
then
  printf "\n\n EXITING : Script must be run on PI OS Buster. \n\n"
  exit 1
fi

printf "\n\n\n Please enter IP of piHeatingHub : "
read HUB_IP
echo

curl -s --head http://$HUB_IP:8080 | sed -n 4p | grep 'Secure Heating Hub' > /dev/null

if [ $? -eq 0 ]
then
  echo "Hub exists"
else
  printf "\n\n First you must install piHeatingHub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/bin/piWeatherLog/README.md" ]
then
  printf "\n\n Installing piWeatherLog ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/bin/piWeatherLog" ]
  then
    rm -rf "/home/pi/bin/piWeatherLog"
  fi

  mv "/home/pi/bin/pi-heating/piWeatherLog/piWeatherLog" "/home/pi/bin/piWeatherLog"
  mv "/home/pi/bin/piWeatherLog/www" "/var/www/piWeatherLog"
  
  chown -R pi:pi "/home/pi/bin/piWeatherLog"
  chmod -R 750 "/home/pi/bin/piWeatherLog"

  chown -R pi:www-data "/var/www/piWeatherLog"
  chmod -R 755 "/var/www/piWeatherLog"

  if [ ! -f "/home/pi/bin/piWeatherLog/README.md" ]
    then
      printf "\n\n EXITING : piWeatherLog installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n piWeatherLog is already installed. \n"
fi

if [ ! -f "/etc/cron.d/piWeatherLog" ]
  then
    cat > /etc/cron.d/piWeatherLog <<CRON
*/2 * * * * pi /bin/bash /home/pi/bin/piWeatherLog/cron/wrapper.sh
CRON
    service cron restart
fi

# configure app

# configure apache virtual host on port 8083

printf "\n\n Configuring Apache ...\n"

if grep -Fxq 'Listen 8083' /etc/apache2/ports.conf; then
	printf "Apache already listening on port 8083 \n"
else
	cat >> /etc/apache2/ports.conf <<PORTS
Listen 8083
PORTS
fi

  cat > /etc/apache2/sites-available/piWeatherLog.conf <<VHOST
<VirtualHost *:8083>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/piWeatherLog/
    <Directory /var/www/piWeatherLog/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST

a2ensite piWeatherLog.conf
service apache2 restart

printf "\n\n Installing additional database tables ...\n"

DB_USER=$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep database | awk '{print $3}')

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

printf "\n\n Adding www-data to groups, dialout and tty ..."
usermod -a -G dialout,tty www-data

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
