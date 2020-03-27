#!/bin/bash

ARG1=$1
ARG2=$2

########## check for arguments
if [ ! $ARG1 ] || [ ! $ARG2]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	scriptDir=$ARG1
	installDir=$ARG2
fi

########## check for root
if [[ `whoami` != "root" ]]; then
  	echo -e "\n\n Error: \n Script must be run as root \n Exiting ..."
  	exit 1
fi

########## check for piHeatinghub
if [ ! -f "$installDir/piHeatingHub/README.md" ]; then
  echo -e "\n\n First you must install piHeatingHub. \n Exiting ..."
  exit 1
fi

########## installation
########## install binaries and web
if [ ! -f "/home/pi/piPowerTempLog/README.md" ]; then  
	if [ -d "/home/pi/piPowerTempLog" ]; then
		echo -e " Deleting old install ..."
		rm -rf "$installDir/piPowerTempLog"
	fi

	echo " Copying new installation ..."
	cp -r "$installDir/pi-heating/piPowerTempLog/piPowerTempLog" "/home/pi/"
	echo -e " Moving web ..."
	mv "$installDir/piPowerTempLog/www" "/var/www/piPowerTempLog"
  
	echo -e " Setting permission ..."
	chown -R pi:pi "$installDir/piPowerTempLog"
	chmod -R 750 "$installDir/piPowerTempLog"

	chown -R pi:www-data "/var/www/piPowerTempLog"
	chmod -R 755 "/var/www/piPowerTempLog"

	if [ ! -f "/home/pi/piPowerTempLog/README.md" ]; then
		echo "\n\n Error: \n piPowerTempLog installation failed"
		exit 1
	fi

else
	echo " piPowerTempLog is already installed. \n"
fi

########## create cron job
echo -e " Creating cron jobs ..."
if [ ! -f "/etc/cron.d/piPowerTempLog" ]; then
    cat > /etc/cron.d/piPowerTempLog <<CRON
MAILTO=""
*/2 * * * * pi /bin/bash $installDir/piPowerTempLog/cron/wrapper.sh >> /dev/null 2>&1
CRON
fi

########## configure apache
echo -e " Setting Apache listen port 8082 ..."
if grep -Fxq 'Listen 8082' /etc/apache2/ports.conf; then
	printf "   Apache already listening on port 8082 \n"
else
	cat >> /etc/apache2/ports.conf <<PORTS
Listen 8082
PORTS
fi

########## add apache site
echo -e " Adding site ..."
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
		
echo -e " Enabling site ..."
a2ensite piPowerTempLog.conf

########## database setup
printf "\n Installing additional database tables ..."

DB_USER=$(cat /$installDir/piHeatingHub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat /$installDir/piHeatingHub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat /$installDir/piHeatingHub/config/config.ini | grep database | awk '{print $3}')

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







