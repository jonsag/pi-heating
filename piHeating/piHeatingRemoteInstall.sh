#!/bin/bash

#          Raspberry Pi setup, 'piHeatingRemote' configuration script.
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


printf "\n\n\n Please enter IP of piHeatingHub : "
read HUB_IP
echo

curl -s --head http://$HUB_IP:8080 | sed -n 4p | grep 'Secure Heating Hub' > /dev/null

if [ $? -eq 0 ]; then
  echo "Hub exists"
else
  printf "\n\n First you must install piHeatingHub. \n\n"
  exit 1
fi


#ENABLE_W1=$( cat /boot/config.txt | grep '^dtoverlay=w1-gpio$' )
#if [[ $ENABLE_W1 == "" ]]; then
#  echo "dtoverlay=w1-gpio" >> /boot/config.txt
#  
#  ENABLE_W1=$( cat /boot/config.txt | grep '^dtoverlay=w1-gpio$' )
#  if [[ $ENABLE_W1 == "" ]]; then  
#    printf "\n\n EXITING : Unable to write to boot config. \n\n"
#    exit 1
#  fi
#  apt-get update -y
#  printf "\n\n REBOOT : Reeboot required to enable one wire module.\n\n"
#  shutdown -r +1
#else
#  printf "\n One wire module enabled. \n"
#  
#  modprobe w1-gpio
#  modprobe w1-therm
#  
#  printf "\n w1_gpio and w1_therm modules enabled. \n"
#fi


APACHE_INSTALLED=$(which apache2)
if [[ "$APACHE_INSTALLED" == "" ]]; then
  printf "\n\n Installing Apache ...\n"
  # Install Apache
  apt-get install apache2 -y
  update-rc.d apache2 enable
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
  # Install Apache
  apt-get install php -y
  
  PHP_INSTALLED=$(which php)
    if [[ "$PHP_INSTALLED" == "" ]]; then
      printf "\n\n EXITING : PHP installation FAILED\n"
      exit 1
    fi
else
  printf "\n\n PHP is already installed. \n"
fi


# Install 'piHeatingRemote' app

if [ ! -f "/home/pi/piHeatingRemote/README.md" ]; then
  printf "\n\n Installing piHeatingRemote ...\n"
  # Install Apache

  if [ -d "/home/pi/piHeatingRemote" ]; then
    rm -rf "/home/pi/piHeatingRemote"
  fi

  cp -rf "/home/pi/pi-heating/piHeating/piHeatingRemote" "/home/pi/piHeatingRemote"
  mv "/home/pi/piHeatingRemote/www" "/var/www/piHeatingRemote"
  
  chown -R pi:pi "/home/pi/piHeatingRemote"
  chmod -R 755 "/home/pi/piHeatingRemote"
  
  chown -R pi:pi "/home/pi/piHeatingRemote/configs"
  chmod -R 755 "/home/pi/piHeatingRemote/configs"
  
  chown -R pi:www-data "/var/www/piHeatingRemote"
  chmod -R 755 "/var/www/piHeatingRemote"
  
  if [ ! -f "/home/pi/piHeatingRemote/README.md" ]; then
      printf "\n\n EXITING : piHeatingRemote installation FAILED\n"
      exit 1
    fi
    
else
  printf "\n\n piHeatingRemote is already installed. \n"
fi

printf "\n\n Changing /boot/config.txt for w1-gpio pin...\n"
if grep -Fxq 'dtoverlay=w1-gpio,gpiopin=14' /boot/config.txt; then
		printf "Already changed"
else
	sed -i 's/dtoverlay=w1-gpio/dtoverlay=w1-gpio,gpiopin=14/g' /boot/config.txt
fi

# configure app

# configure apache virtual host on port 8081

printf "\n\n Configuring Apache ...\n"

if grep -Fxq 'Listen 8081' /etc/apache2/ports.conf; then
	printf "Apache already listening on port 8081 \n"
else
	cat >> /etc/apache2/ports.conf <<PORTS
Listen 8081
PORTS
fi

  cat > /etc/apache2/sites-available/piHeatingRemote.conf <<VHOST
<VirtualHost *:8081>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/piHeatingRemote/

    <Directory /var/www/piHeatingRemote/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST

a2ensite piHeatingRemote.conf
service apache2 restart

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
