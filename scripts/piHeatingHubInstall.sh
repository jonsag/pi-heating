#!/bin/bash

########## check for arguments
if [ ! $1 ] || [ ! $2]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	$scriptDir=$1
	$installDir=$2
fi

########## check for root
if [[ `whoami` != "root" ]]; then
  	echo -e "\n\n Error: \n Script must be run as root."
  	exit 1
fi

########## installation
if [ ! -f "$installDir/piHeatingHub/README.md" ]; then
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping install"
	else
  		if [ -d "$installDir/piHeatingHub" ]; then
  			echo -e " Deleting old directory ..."
	    	rm -rf "$installDir/piHeatingHub"
	  	fi
	
		echo -e " Copying binaries ..."
	  	cp -rf "$scriptDir/piHeating/piHeatingHub" "$installDir/piHeatingHub"
	  	echo -e " Moving web ..."
	  	mv "$installDir/piHeatingHub/www" "/var/www/piHeatingHub"
	  
	  	echo -e " Creating data directories ..."
	  	if [ ! -d "/var/www/piHeatingHub/data" ]; then
	    	mkdir "/var/www/piHeatingHub/data"
	  	fi
	  	mkdir "$installDir/piHeatingHub/data"
	  	
	  	echo -e " Setting permissions ..."
	  	chown -R pi:www-data "$installDir/piHeatingHub"
	  	chmod -R 750 "$installDir/piHeatingHub"
	  	chown -R pi:www-data "$installDir/piHeatingHub/data"
	  	chmod -R 775 "$installDir/piHeatingHub/data"
	  
	  	chown -R pi:www-data "/var/www/piHeatingHub"
	  	chmod -R 755 "/var/www/piHeatingHub"
	  	chmod -R 775 "/var/www/piHeatingHub/images"

  		if [ ! -f "$installDir/piHeatingHub/README.md" ]; then
  			echo " Error: \n piHeatingHub installation failed\n"
  			exit 1
		fi
	fi
else
  	echo " piHeatingHub is already installed"
fi

########## create cron job
echo -e " Creating cron jobs ..."
if [ ! -f "/etc/cron.d/piHeating" ]; then
    cat > /etc/cron.d/piHeating <<CRON
MAILTO=""
* * * * * pi /bin/bash $installDir/piHeatingHub/cron/piHeatingHubWrapper.sh >> /dev/null 2>&1
CRON
    service cron restart
fi
		
########## configure apache
echo -e " Setting Apache listen port..."
if grep -Fxq 'Listen 8080' /etc/apache2/ports.conf; then
	printf "Apache already listening on port 8080 \n"
else
	cat >> /etc/apache2/ports.conf <<PORTS
Listen 8080
PORTS
fi

########## add apache site
echo -e " Adding site ..."
cat > /etc/apache2/sites-available/piHeatingHub.conf <<VHOST
<VirtualHost *:8080>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/piHeatingHub/
    <Directory /var/www/piHeatingHub/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST
		
echo -e " Enabling site ..."
a2ensite piHeatingHub.conf

########## database setup
echo -e "\n\n Setting up database ... \n ----------"
echo -e " Please enter the MariaDB 'root' password : "
read -s ROOT_PASSWORD



echo -e "     Creating database: $DB_NAME \n at host: $DB_SERVER \n Setting username: $DB_USER \n with password: $DB_PASSWORD"
mysql -uroot -p$ROOT_PASSWORD<< DATABASE

CREATE DATABASE $DB_NAME CHARACTER SET = utf8;

CREATE USER '$DB_USERNAME'@'$DB_SERVER';
SET PASSWORD FOR '$DB_USERNAME'@'$DB_SERVER' = PASSWORD('$DB_PASSWORD');

GRANT ALL ON $DB_NAME.* TO '$DB_USERNAME'@'$DB_SERVER';

USE $DB_NAME;

CREATE TABLE IF NOT EXISTS devices   (      d_id          int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            name          varchar(256)  NOT NULL,
                                            pin           int(11)       DEFAULT NULL,
                                            active_level  tinyint(4)    DEFAULT NULL,
                                            value         tinyint(1)    DEFAULT 0 );

CREATE TABLE IF NOT EXISTS sensors   (      id            bigint(11)    NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            ref           varchar(20)   DEFAULT NULL,
                                            name          varchar(256)  DEFAULT NULL,
                                            ip            varchar(16)   DEFAULT NULL,
                                            value         float         DEFAULT NULL,
                                            unit          varchar(11)   NOT NULL );

CREATE TABLE IF NOT EXISTS timers    (      id            int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            name          varchar(256)  DEFAULT NULL,
                                            duration      int(11)       DEFAULT NULL,
                                            value         int(11)       DEFAULT NULL ); 

CREATE TABLE IF NOT EXISTS modes     (      id            int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            name          varchar(256)  DEFAULT NULL,
                                            value         tinyint(1)    DEFAULT NULL );
                                            
CREATE TABLE IF NOT EXISTS network   (      id            int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            mac           varchar(17)   DEFAULT NULL,
                                            name          varchar(256)  DEFAULT NULL,
                                            value         tinyint(1)    DEFAULT NULL );
                            
CREATE TABLE IF NOT EXISTS schedules (      id            int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                            name          varchar(256)  DEFAULT NULL,
                                            start         time DEFAULT  NULL,
                                            end           time DEFAULT  NULL,  
                                            dow1          tinyint(1)    NOT NULL DEFAULT '0',
                                            dow2          tinyint(1)    NOT NULL DEFAULT '0',
                                            dow3          tinyint(1)    NOT NULL DEFAULT '0',
                                            dow4          tinyint(1)    NOT NULL DEFAULT '0',
                                            dow5          tinyint(1)    NOT NULL DEFAULT '0',
                                            dow6          tinyint(1)    NOT NULL DEFAULT '0',
                                            dow7          tinyint(1)    NOT NULL DEFAULT '0',
                                            enabled       tinyint(1)    NOT NULL DEFAULT '1',
                                            active        tinyint(1)    DEFAULT NULL );

CREATE TABLE IF NOT EXISTS sched_device (   sd_id         int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            sched_id      int(11)       DEFAULT NULL,
                                            device_id     int(11)       DEFAULT NULL );

CREATE TABLE IF NOT EXISTS sched_sensor (   ss_id         int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            sched_id      int(11)       DEFAULT NULL,
                                            sensor_id     int(11)       DEFAULT NULL,
                                            opp           char(1)       DEFAULT NULL,
                                            value         float         DEFAULT NULL );

CREATE TABLE IF NOT EXISTS sched_timer (    st_id         int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            sched_id      int(11)       DEFAULT NULL,
                                            timer_id      int(11)       DEFAULT NULL,
                                            opp           char(1)       DEFAULT NULL,
                                            value         tinyint(1)    DEFAULT NULL );

CREATE TABLE IF NOT EXISTS sched_mode (     sm_id         int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            sched_id      int(11)       DEFAULT NULL,
                                            mode_id       int(11)       DEFAULT NULL,
                                            test_opp      char(1)       DEFAULT NULL,
                                            test_value    tinyint(1)    DEFAULT NULL );
                                            
CREATE TABLE IF NOT EXISTS sched_network (  sn_id         int(11)       NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            sched_id      int(11)       DEFAULT NULL,
                                            network_id    int(11)       DEFAULT NULL,
                                            test          tinyint(1)    DEFAULT NULL );

DATABASE	
		
echo -e "\n\n Saving database credentials ... \n ----------"
cat > $installDir/piHeatingHub/config/config.ini <<CONFIG
[db]
server = $DB_SERVER
user = $DB_USERNAME
password = $DB_PASSWORD
database = $DB_NAME
CONFIG

