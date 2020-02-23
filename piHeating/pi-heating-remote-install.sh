#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-remote' configuration script.
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


printf "\n\n\n Please enter IP of pi-heating-hub : "
read HUB_IP
echo

curl -s --head http://$HUB_IP:8080 | sed -n 4p | grep 'Secure Heating Hub' > /dev/null

if [ $? -eq 0 ]
then
  echo "Hub exists"
else
  printf "\n\n First you must install pi-heating-hub. \n\n"
  exit 1
fi


ENABLE_W1=$( cat /boot/config.txt | grep '^dtoverlay=w1-gpio$' )
if [[ $ENABLE_W1 == "" ]]
then
  echo "dtoverlay=w1-gpio" >> /boot/config.txt
  
  ENABLE_W1=$( cat /boot/config.txt | grep '^dtoverlay=w1-gpio$' )
  if [[ $ENABLE_W1 == "" ]]
  then  
    printf "\n\n EXITING : Unable to write to boot config. \n\n"
    exit 1
  fi
  apt-get update -y
  printf "\n\n REBOOT : Reeboot required to enable one wire module.\n\n"
  shutdown -r +1
else
  printf "\n One wire module enabled. \n"
  
  modprobe w1-gpio
  modprobe w1-therm
  
  printf "\n w1_gpio and w1_therm modules enabled. \n"
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


# Install 'pi-heating-remote' app

if [ ! -f "/home/pi/pi-heating-remote/README.md" ]
then
  printf "\n\n Installing pi-heating-remote ...\n"
  # Install Apache

  if [ -d "/home/pi/pi-heating-remote" ]
  then
    rm -rf "/home/pi/pi-heating-remote"
  fi

  mv "/home/pi/pi-heating/pi-heating-remote" "/home/pi/pi-heating-remote"
  mv "/home/pi/pi-heating-remote/www" "/var/www/pi-heating-remote"
  
  chown -R pi:pi "/home/pi/pi-heating-remote"
  chmod -R 755 "/home/pi/pi-heating-remote"
  
  chown -R pi:pi "/home/pi/pi-heating-remote/configs"
  chmod -R 755 "/home/pi/pi-heating-remote/configs"
  
  chown -R pi:www-data "/var/www/pi-heating-remote"
  chmod -R 755 "/var/www/pi-heating-remote"
  
  if [ ! -f "/home/pi/pi-heating-remote/README.md" ]
    then
      printf "\n\n EXITING : pi-heating-remote installation FAILED\n"
      exit 1
    fi
    
else
  printf "\n\n pi-heating-remote is already installed. \n"
fi


# configure app

# configure apache virtual host on port 8081

printf "\n\n Configuring Apache ...\n"

  cat >> /etc/apache2/ports.conf <<PORTS
Listen 8081
PORTS

  cat > /etc/apache2/sites-available/pi-heating-remote.conf <<VHOST
<VirtualHost *:8081>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/pi-heating-remote/

    <Directory /var/www/pi-heating-remote/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>
    
    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
VHOST

a2ensite pi-heating-remote.conf
service apache2 restart

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
