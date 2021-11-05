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
echo -e "\n\n Installing piWeatherLog ... \n ----------"

if [ -f "$installDir/piWeatherLog/README.md" ]; then
    echo "     piWeatherLog is already installed"
else
    if [ $simulate ]; then
        echo "$simulateMessage"
    else
        if [ -d "$installDir/piWeatherLog" ]; then
            echo -e " Deleting old install ..."
            rm -rf "$installDir/piWeatherLog"
        fi
        
        echo " Copying new installation ..."
        mv "$scriptDir/piWeatherLog/piWeatherLog" "$installDir/"
        
        echo -e " Moving web ..."
        mv "$installDir/piWeatherLog/www" "/var/www/piWeatherLog"
        
        echo -e " Setting permission ..."
        chown -R pi:pi "$installDir/piWeatherLog"
        chmod -R 750 "$installDir/piWeatherLog"
        
        chown -R pi:www-data "/var/www/piWeatherLog"
        chmod -R 755 "/var/www/piWeatherLog"
    fi
fi

########## create cron job
echo -e " Creating cron job ..."
if [ -f "/etc/cron.d/piWeatherLog" ]; then
    echo "     Cron job already exists"
else
    if [ $simulate ]; then
        echo "$simulateMessage"
    else
		cat > /etc/cron.d/piWeatherLog <<CRON
MAILTO=""
@reboot pi /bin/bash $installDir/piWeatherLog/cron/bootWrapper.sh
*/2 * * * * pi /bin/bash $installDir/piWeatherLog/cron/wrapper.sh
CRON
    fi
fi

########## configure apache
echo -e " Setting Apache listen port 8083 ..."
if grep -Fxq 'Listen 8083' /etc/apache2/ports.conf; then
    echo "   Apache already listening on port 8083"
else
    if [ $simulate ]; then
        echo "$simulateMessage"
    else
		cat >> /etc/apache2/ports.conf <<PORTS
Listen 8083
PORTS
    fi
fi

########## add apache site
echo -e " Adding site ..."
if [ -f /etc/apache2/sites-available/piWeatherLog.conf ]; then
    echo "     Site already exists"
else
    if [ $simulate ]; then
        echo "$simulateMessage"
    else
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
    fi
fi

########## enable site
echo -e " Enabling site ..."
if [ $simulate ]; then
    echo "$simulateMessage"
else
    a2ensite piWeatherLog.conf
fi

########## database setup
echo -e " Installing additional database tables ..."
if [ $simulate ]; then
    echo "$simulateMessage"
else
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
fi

###### set groups
echo -e " Adding www-data to groups, dialout and tty ..."
if [ $simulate ]; then
    echo "$simulateMessage"
else
    usermod -a -G dialout,tty www-data
fi





