#!/bin/bash

ARG1=$1
ARG2=$2

########## check for arguments
if [ ! $ARG1 ] || [ ! $ARG2 ]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	scriptDir=$ARG1
	installDir=$ARG2
fi

########## check for root
if [[ `whoami` != "root" ]]; then
	echo -e "\n\n Error: \n Script must be run as root  \n Exiting ..."
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		exit 1
	fi
fi

########## check for piHeatinghub
if [ ! -f "$installDir/piHeatingHub/README.md" ]; then
  echo -e "\n\n First you must install piHeatingHub. \n Exiting ..."
  exit 1
fi

########## installation
echo -e "\n\n Installing piPowerTempLog ... \n ----------"

########## install binaries and web
if [ -f "$installDir/piPowerTempLog/README.md" ]; then
	echo "     piPowerTempLog is already installed"
else 
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		if [ -d "$installDir/piPowerTempLog" ]; then
			echo -e " Deleting old install ..."
			rm -rf "$installDir/piPowerTempLog"
		fi
	
		echo " Copying new installation ..."
		cp -r "$scriptDir/piPowerTempLog/piPowerTempLog" "$installDir/"
		
		echo -e " Moving web ..."
		mv "$installDir/piPowerTempLog/www" "/var/www/piPowerTempLog"
	  
		echo -e " Setting permission ..."
		chown -R pi:pi "$installDir/piPowerTempLog"
		chmod -R 750 "$installDir/piPowerTempLog"
	
		chown -R pi:www-data "/var/www/piPowerTempLog"
		chmod -R 755 "/var/www/piPowerTempLog"
	fi
fi

########## create cron job
echo -e " Creating cron job ..."
if [ -f "/etc/cron.d/piPowerTempLog" ]; then
	echo "     Cron job already exists"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
    	cat > /etc/cron.d/piPowerTempLog <<CRON
MAILTO=""
*/2 * * * * pi /bin/bash $installDir/piPowerTempLog/cron/wrapper.sh >> /dev/null 2>&1
CRON
	fi
fi

########## configure apache
echo -e " Setting Apache listen port 8082 ..."
if grep -Fxq 'Listen 8082' /etc/apache2/ports.conf; then
	echo "   Apache already listening on port 8082"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		cat >> /etc/apache2/ports.conf <<PORTS
Listen 8082
PORTS
	fi
fi

########## add apache site
echo -e " Adding site ..."
if [ -f /etc/apache2/sites-available/piPowerTempLog.conf ]; then
	echo "     Site already exists"
else
	if [ $simulate ]; then
	  	echo "$simulateMessage"
	else
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

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST
	fi
fi
		
########## enable site
echo -e " Enabling site ..."
if [ $simulate ]; then
  	echo "$simulateMessage"
else
	a2ensite piPowerTempLog.conf
fi

########## database setup
echo -e " Installing additional database tables ..."
if [ $simulate ]; then
	echo "$simulateMessage"
else
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
fi







