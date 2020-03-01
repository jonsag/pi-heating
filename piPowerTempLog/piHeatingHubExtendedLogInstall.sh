#!/bin/bash

#          Raspberry Pi setup, 'piHeatingHub-extended-log' configuration script.

# Die on any errors

#set -e
clear


if [[ `whoami` != "root" ]]; then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi


OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"stretch"* ]]; then
  printf "\n\n EXITING : Script must be run on PI OS Stretch. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/piHeatingHub/README.md" ]; then
  printf "\n\n First you must install piHeatingHub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/piHeatingHubExtendedLog/README.md" ]; then
  printf "\n\n Installing piHeatingHub-extended-log ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/piHeatingHubExtendedLog" ]; then
    rm -rf "/home/pi/piHeatingHubExtendedLog"
  fi

  cp -r "/home/pi/pi-heating/piHeatingHubExtendedLog" "/home/pi/piHeatingHubExtendedLog"
  mv "/home/pi/piHeatingHubExtendedLog/www" "/var/www/html/piHeatingHubExtendedLog"
  
  chown -R pi:pi "/home/pi/piHeatingHubExtendedLog"
  chmod -R 750 "/home/pi/piHeatingHubExtendedLog"

  chown -R pi:www-data "/var/www/html/piHeatingHubExtendedLog"
  chmod -R 755 "/var/www/html/piHeatingHubExtendedLog"

  if [ ! -f "/home/pi/piHeatingHubExtendedLog/README.md" ]; then
      printf "\n\n EXITING : piHeatingHub-extended-log installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n piHeatingHub-extended-log is already installed. \n"
fi

if [ ! -f "/etc/cron.d/piHeatingHubExtendedLog" ]; then
    cat > /etc/cron.d/piHeatingHubExtendedLog <<CRON
MAILTO=""
*/2 * * * * pi /bin/bash /home/pi/piHeatingHubExtendedLog/cron/wrapper.sh >> /dev/null 2>&1
CRON
    service cron restart
fi


# configure app

# configure apache virtual host on port 8082

printf "\n\n Configuring Apache ...\n"

if grep -Fxq 'Listen 8082' /etc/apache2/ports.conf; then
	printf "Apache already listening on port 8082 \n"
else
  cat >> /etc/apache2/ports.conf <<PORTS
Listen 8082
PORTS
fi
  cat > /etc/apache2/sites-available/piHeatingHubExtendedLog.conf <<VHOST
<VirtualHost *:8082>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/piHeatingHubExtendedLog/
    <Directory /var/www/html/piHeatingHubExtendedLog/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
VHOST

a2ensite piHeatingHubExtendedLog.conf
service apache2 restart


printf "\n\n Installing additional database tables ...\n"

DB_USER=$(cat /home/pi/piHeatingHub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /home/pi/piHeatingHub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /home/pi/piHeatingHub/config/config.ini | grep database | awk '{print $3}')

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

DATABASE

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
