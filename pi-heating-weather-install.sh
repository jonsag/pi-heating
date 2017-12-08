#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-hub' configuration script.
# Author : Jeffrey.Powell ( jffrypwll <at> googlemail <dot> com )
# Date   : Nov 2016

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


APACHE_INSTALLED=$(which apache2)
if [[ "$APACHE_INSTALLED" == "" ]]
then
  printf "\n\n Installing Apache ...\n"
  # Install Apache
  apt-get install apache2 -y
  update-rc.d apache2 enable
  a2dissite 000-default.conf
  service apache2 restart

  APACHE_INSTALLED=$(which apache2)
    if [[ "$APACHE_INSTALLED" == "" ]]
    then
      printf "\n\n EXITING : Apache installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n Apache is already installed. \n"
fi


PHP_INSTALLED=$(which php)
if [[ "$PHP_INSTALLED" == "" ]]
then
  printf "\n\n Installing PHP ...\n"
  # Install Apache
  apt-get install php -y

  PHP_INSTALLED=$(which php)
    if [[ "$PHP_INSTALLED" == "" ]]
    then
      printf "\n\n EXITING : PHP installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n PHP is already installed. \n"
fi


MYSQL_INSTALLED=$(which mysql)
if [[ "$MYSQL_INSTALLED" == "" ]]
then
  printf "\n\n Installing MYSQL ...\n"
  # Install Apache
  apt-get install mysql-server -y --fix-missing

  MYSQL_INSTALLED=$(which mysql)
    if [[ "$MYSQL_INSTALLED" == "" ]]
    then
      printf "\n\n EXITING : MYSQL installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n MYSQL is already installed. \n"
fi


PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
if [[ "$PHPMYSQL_INSTALLED" == "" ]]
then
  printf "\n\n Installing MYSQL PHP Module ...\n"
  # Install Apache
  apt-get install php-mysql -y

  PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
    if [[ "$PHPMYSQL_INSTALLED" == "" ]]
    then
      printf "\n\n EXITING : MYSQL PHP Module installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n MYSQL PHP Module is already installed. \n"
fi


PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
if [[ "$PYMYSQL_INSTALLED" == "" ]]
then
  printf "\n\n Installing MYSQL Python Module ...\n"
  # Install Apache
  apt-get install python-mysqldb -y

  PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
    if [[ "$PYMYSQL_INSTALLED" == "" ]]
    then
      printf "\n\n EXITING : MYSQL Python Module installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n MYSQL Python Module is already installed. \n"
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

if [ ! -f "/etc/cron.d/pi-weather" ]
  then
    cat > /etc/cron.d/pi-weathher <<CRON
* * * * * pi /bin/bash /home/pi/pi-heating-weather/cron/wrapper.sh
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


printf "\n\n Installing additional database tablse ...\n"

source "/home/pi/pi-heating-hub/config/config.ini"

mysql -u$user -p$password $database<< DATABASE

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
