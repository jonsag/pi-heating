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
if [[ $OS_VERSION != *"buster"* ]]; then
  printf "\n\n EXITING : Script must be run on PI OS Buster. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/bin/piHeatingHub/README.md" ]; then
  printf "\n\n First you must install piHeatingHub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/piPowerTempLog/README.md" ]; then
  printf "\n\n Installing piHeatingHub-extended-log ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/piPowerTempLog" ]; then
  	printf "\n\n Deleting old install ...\n"
    rm -rf "/home/pi/piPowerTempLog"
  fi

  printf "\n\n Copying new installation ...\n"
  cp -r "/home/pi/pi-heating/piPowerTempLog/piPowerTempLog" "/home/pi/"
  printf "\n\n Moving www files ...\n"
  mv "/home/pi/piPowerTempLog/www" "/var/www/piPowerTempLog"
  
  printf "\n\n Setting permission ...\n"
  chown -R pi:pi "/home/pi/piPowerTempLog"
  chmod -R 750 "/home/pi/piPowerTempLog"

  chown -R pi:www-data "/var/www/piPowerTempLog"
  chmod -R 755 "/var/www/piPowerTempLog"

  if [ ! -f "/home/pi/piPowerTempLog/README.md" ]; then
      printf "\n\n EXITING : piHeatingHub-extended-log installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n piHeatingHub-extended-log is already installed. \n"
fi

printf "\n\n Creating cron job ...\n"
if [ ! -f "/etc/cron.d/piPowerTempLog" ]; then
    cat > /etc/cron.d/piPowerTempLog <<CRON
MAILTO=""
*/2 * * * * pi /bin/bash /home/pi/piPowerTempLog/cron/wrapper.sh >> /dev/null 2>&1
CRON
	printf "\n\n Restarting cron ...\n"
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
  cat > /etc/apache2/sites-available/piPowerTempLog.conf <<VHOST
<VirtualHost *:8082>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/piPowerTempLog/
    <Directory /var/www/piPowerTempLog/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST

a2ensite piPowerTempLog.conf
service apache2 restart


printf "\n\n Installing additional database tables ...\n"

DB_USER=$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep database | awk '{print $3}')

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
