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
if [[ $OS_VERSION != *"stretch"* ]]
then
  printf "\n\n EXITING : Script must be run on PI OS Stretch. \n\n"
  exit 1
fi

printf "\n\n\n Please enter IP of pi-heating-hub : "
read -s HUB_IP
echo

if [ ! -f "/home/pi/pi-heating-hub/README.md" ]
then
  printf "\n\n First you must install pi-heating-hub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/pi-heating-weather/README.md" ]
then
  printf "\n\n Installing pi-heating-weather ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/pi-heating-weather" ]
  then
    rm -rf "/home/pi/pi-heating-weather"
  fi

  mv "/home/pi/pi-heating/pi-heating-weather" "/home/pi/pi-heating-weather"
  mv "/home/pi/pi-heating-weather/www" "/var/www/pi-heating-weather"
  
  chown -R pi:pi "/home/pi/pi-heating-weather"
  chmod -R 750 "/home/pi/pi-heating-weather"

  chown -R pi:www-data "/var/www/pi-heating-weather"
  chmod -R 755 "/var/www/pi-heating-weather"

  if [ ! -f "/home/pi/pi-heating-weather/README.md" ]
    then
      printf "\n\n EXITING : pi-heating-weather installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n pi-heating-weather is already installed. \n"
fi

if [ ! -f "/etc/cron.d/pi-heating-weather" ]
  then
    cat > /etc/cron.d/pi-heating-weather <<CRON
*/2 * * * * pi /bin/bash /home/pi/pi-heating-weather/cron/wrapper.sh
CRON
    service cron restart
fi


# configure app

# configure apache virtual host on port 8082

printf "\n\n Configuring Apache ...\n"

  cat >> /etc/apache2/ports.conf <<PORTS
Listen 8082
PORTS

  cat > /etc/apache2/sites-available/pi-heating-weather.conf <<VHOST
<VirtualHost *:8082>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/pi-heating-weather/
    <Directory /var/www/pi-heating-weather/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
VHOST

a2ensite pi-heating-weather.conf
service apache2 restart


printf "\n\n\n Please enter the MySQL root password : "
read -s ROOT_PASSWORD
echo

printf "\n\n\n Please enter subnet, eg. 192.168.0.% : "
read -s DB_SUBNET
echo

mysql -uroot -p$ROOT_PASSWORD<< DATABASE

CREATE USER '$DB_USERNAME'@'$DB_SUBNET';
SET PASSWORD FOR '$DB_USERNAME'@'$DB_SUBNET' = PASSWORD('DB_PASSWORD');

GRANT ALL ON $DB_NAME.* TO '$DB_USERNAME'@'$DB_SUBNET';

FLUSH PRIVILEGES;

printf "\n\n Installing additional database tables ...\n"

DB_USER=$(cat /home/pi/pi-heating-weather/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /home/pi/pi-heating-weather/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /home/pi/pi-heating-weather/config/config.ini | grep database | awk '{print $3}')

CREATE TABLE IF NOT EXISTS powerLog (
	id							INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    ts							TIMESTAMP,
	currentR1					FLOAT,
	currentS2					FLOAT,
	currentT3					FLOAT,
	currentAverageR1			FLOAT,
	currentAverageS2			FLOAT,
	currentAverageT3			FLOAT,
	pulses						INT,
	event						char(255),
    PRIMARY KEY (id)
) CHARACTER SET UTF8;

CREATE TABLE IF NOT EXISTS tempLog (
    id							INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    ts							TIMESTAMP,
	sensorid					bigint(11),
	value						float,
    event						char(255),
    PRIMARY KEY (id)
) CHARACTER SET UTF8;

CREATE TABLE IF NOT EXISTS weatherLog (
    id							INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    ts							TIMESTAMP,
    windDirection				char(3),
    windDirectionValue			FLOAT,
    averageWindDirectionValue	FLOAT,
    windSpeed					FLOAT,
    averageWindSpeed			FLOAT,
    rainSinceLast				FLOAT,
    event						char(255),
    PRIMARY KEY (id)
) CHARACTER SET UTF8;

DATABASE

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
