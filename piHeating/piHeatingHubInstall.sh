#!/bin/bash

#          Raspberry Pi setup, 'piHeatingHub' configuration script.
# Author : Jeffrey.Powell ( jffrypwll <at> googlemail <dot> com )
# Date   : Nov 2016

# Tweaked by: Jon Sagebrand ( jonsagebrand <at> gmail <dot> com )
# Date      : Feb 2020

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


APACHE_INSTALLED=$(which apache2)
if [[ "$APACHE_INSTALLED" == "" ]]; then
  printf "\n\n Installing Apache ...\n"
  # Install Apache
  apt install apache2 apache2-utils -y
  systemctl enable apache2
  a2dissite 000-default.conf
  service apache2 restart

  APACHE_INSTALLED=$(which apache2)
    if [[ "$APACHE_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : Apache installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n Apache is already installed. \n"
fi


PHP_INSTALLED=$(which php)
if [[ "$PHP_INSTALLED" == "" ]]; then
  printf "\n\n Installing PHP ...\n"
  # Install PHP
  apt install php libapache2-mod-php php-common php-cli php-json php-readline-y

  PHP_INSTALLED=$(which php)
    if [[ "$PHP_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : PHP installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n PHP is already installed. \n"
fi


MYSQL_INSTALLED=$(which mariadb)
if [[ "$MYSQL_INSTALLED" == "" ]]; then
  printf "\n\n Installing MySQL ...\n"
  # Install MySQL
  apt-get install mariadb-server mariadb-client -y --fix-missing

  MYSQL_INSTALLED=$(which mariadb)
    if [[ "$MYSQL_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : MySQL installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n MySQL is already installed. \n"
fi


PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
if [[ "$PHPMYSQL_INSTALLED" == "" ]]; then
  printf "\n\n Installing MySQL PHP Module ...\n"
  # Install MySQL PHP Module
  apt-get install php-mysql -y

  PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
    if [[ "$PHPMYSQL_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : MySQL PHP Module installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n MySQL PHP Module is already installed. \n"
fi


PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
if [[ "$PYMYSQL_INSTALLED" == "" ]]; then
  printf "\n\n Installing MySQL Python Module ...\n"
  # Install MySQL Python Module
  apt-get install python-mysqldb -y

  PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
    if [[ "$PYMYSQL_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : MySQL Python Module installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n MySQL Python Module is already installed. \n"
fi


RRD_INSTALLED=$(find /var/lib/dpkg -name rrdtool*)
if [[ "$RRD_INSTALLED" == "" ]]; then
  printf "\n\n Installing RRD tool ...\n"
  # Install RRD tool
  apt-get install rrdtool php-rrd -y

  RRD_INSTALLED=$(find /var/lib/dpkg -name rrdtool*)
    if [[ "$RRD_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : RRD tool installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n RRD tool is already installed. \n"
fi


NMP_INSTALLED=$(find /var/lib/dpkg -name nmap*)
if [[ "$NMP_INSTALLED" == "" ]]; then
  printf "\n\n Installing nmap ...\n"
  # Install nmap
  apt-get install nmap -y

  NMP_INSTALLED=$(find /var/lib/dpkg -name nmap*)
    if [[ "$NMP_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : nmap  installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n nmap is already installed. \n"
fi


# Install 'piHeatingHub' app

if [ ! -f "/home/pi/piHeatingHub/README.md" ]; then
  printf "\n\n Installing piHeatingHub ...\n"

  if [ -d "/home/pi/piHeatingHub" ]; then
    rm -rf "/home/pi/piHeatingHub"
  fi

  cp -rf "/home/pi/pi-heating/piHeating/piHeatingHub" "/home/pi/piHeatingHub"
  mv "/home/pi/piHeatingHub/www" "/var/www/piHeatingHub"
  
  chown -R pi:www-data "/home/pi/piHeatingHub"
  chmod -R 750 "/home/pi/piHeatingHub"
  
  if [ ! -d "/var/www/piHeatingHub/data" ]; then
    mkdir "/var/www/piHeatingHub/data"
  fi
  
  mkdir "/home/pi/piHeatingHub/data"
  chown -R pi:www-data "/home/pi/piHeatingHub/data"
  chmod -R 775 "/home/pi/piHeatingHub/data"
  
  chown -R pi:www-data "/var/www/piHeatingHub"
  chmod -R 755 "/var/www/piHeatingHub"
  chmod -R 775 "/var/www/piHeatingHub/images"

  if [ ! -f "/home/pi/piHeatingHub/README.md" ]; then
      printf "\n\n EXITING : piHeatingHub installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n piHeatingHub is already installed. \n"
fi


if [ ! -f "/etc/cron.d/piHeating" ]; then
    cat > /etc/cron.d/piHeating <<CRON
MAILTO=""
* * * * * pi /bin/bash /home/pi/piHeatingHub/cron/piHeatingHubWrapper.sh >> /dev/null 2>&1
CRON
    service cron restart
  fi
  
if [ ! -f "/etc/mysql/mariadb.conf.d/99-disable-strict-mode.cnf" ]; then
    cat > /etc/mysql/mariadb.conf.d/99-disable-strict-mode.cnf <<STRICT
[server]
sql_mode = ""
STRICT

  fi


# configure app

# configure apache virtual host on port 8080

printf "\n\n Configuring Apache ...\n"

if grep -Fxq 'Listen 8080' /etc/apache2/ports.conf; then
	printf "Apache already listening on port 8080 \n"
else
	cat >> /etc/apache2/ports.conf <<PORTS
Listen 8080
PORTS
fi

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

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
VHOST

a2ensite piHeatingHub.conf
a2enmod php7.3
service apache2 restart

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
