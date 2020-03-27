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
if [ ! -f "$installDir/piWeatherLog/README.md" ]; then
  	echo -e "\n\n Installing piWeatherLog ...\n"  
  	if [ -d "$installDir/piWeatherLog" ]; then
    	rm -rf "$installDir/piWeatherLog"
  	fi

  	mv "$scriptDir/pi-heating/piWeatherLog/piWeatherLog" "$installDir/"
  	mv "$installDir/piWeatherLog/www" "/var/www/piWeatherLog"
  
  	chown -R pi:pi "$installDir/piWeatherLog"
  	chmod -R 750 "$installDir/piWeatherLog"

  	chown -R pi:www-data "/var/www/piWeatherLog"
  	chmod -R 755 "/var/www/piWeatherLog"

  	if [ ! -f "$installDir/piWeatherLog/README.md" ]; then
      	echo -e "\n\n Error: \n piWeatherLog installation failed\n"
      	exit 1
  	fi

else
  	echo -e "\n\n piWeatherLog is already installed. \n"
fi

if [ ! -f "/etc/cron.d/piWeatherLog" ]; then
	cat > /etc/cron.d/piWeatherLog <<CRON
*/2 * * * * pi /bin/bash $installDir/piWeatherLog/cron/wrapper.sh
CRON
fi


echo -e "\n\n Configuring Apache ...\n"

if grep -Fxq 'Listen 8083' /etc/apache2/ports.conf; then
	echo -e "Apache already listening on port 8083 \n"
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

echo -e " Installing additional database tables ..."
DB_USER=$(cat $installDir/piHeatingHub/config/config.ini | grep user | awk '{print $3}')
DB_PASSWORD=$(cat $installDir/piHeatingHub/config/config.ini | grep password | awk '{print $3}')
DB=$(cat $installDir/piHeatingHub/config/config.ini | grep database | awk '{print $3}')

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

echo -e " Adding www-data to groups, dialout and tty ..."
usermod -a -G dialout,tty www-data
