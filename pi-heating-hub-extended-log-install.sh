#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-hub-extended-log' configuration script.

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


if [ ! -f "/home/pi/pi-heating-hub-extended-log/README.md" ]
then
  printf "\n\n Installing pi-heating-hub-extended-log ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/pi-heating-hub-extended-log" ]
  then
    rm -rf "/home/pi/pi-heating-hub-extended-log"
  fi

  mv "/home/pi/pi-heating/pi-heating-hub-extended-log" "/home/pi/pi-heating-hub-extended-log"
  mv "/home/pi/pi-heating-hub-extended-log/www" "/var/www/pi-heating-hub-extended-log"
  
  chown -R pi:pi "/home/pi/pi-heating-hub-extended-log"
  chmod -R 750 "/home/pi/pi-heating-hub-extended-log"

  chown -R pi:www-data "/var/www/pi-heating-hub-extended-log"
  chmod -R 755 "/var/www/pi-heating-hub-extended-log"

  if [ ! -f "/home/pi/pi-heating-hub-extended-log/README.md" ]
    then
      printf "\n\n EXITING : pi-heating-hub-extended-log installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n pi-heating-hub-extended-log is already installed. \n"
fi

if [ ! -f "/etc/cron.d/pi-weather" ]
  then
    cat > /etc/cron.d/pi-heating-hub-extended-log <<CRON
* * * * * pi /bin/bash /home/pi/pi-heating-hub-extended-log/cron/wrapper.sh
CRON
    service cron restart
fi


# configure app

# configure apache virtual host on port 8082

printf "\n\n Configuring Apache ...\n"

  cat >> /etc/apache2/ports.conf <<PORTS
Listen 8082
PORTS

  cat > /etc/apache2/sites-available/pi-heating-hub-extended-log.conf <<VHOST
<VirtualHost *:8082>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/pi-heating-hub-extended-log/
    <Directory /var/www/pi-heating-hub-extended-log/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
VHOST

a2ensite pi-heating-hub-extended-log.conf
service apache2 restart


printf "\n\n Installing additional database tables ...\n"

DB_USER=$(cat /home/pi/pi-heating-hub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /home/pi/pi-heating-hub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /home/pi/pi-heating-hub/config/config.ini | grep database | awk '{print $3}')

mysql -u$DB_USER -p$DB_PASSWORD $DB<< DATABASE

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
