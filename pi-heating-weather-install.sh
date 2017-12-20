#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-weather' configuration script.

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

#if [ ! -f "/home/pi/pi-heating-hub/README.md" ]
#then
#  printf "\n\n First you must install pi-heating-hub. \n\n"
#  exit 1
#fi


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


# configure app

# configure apache virtual host on port 8083

printf "\n\n Configuring Apache ...\n"

  cat >> /etc/apache2/ports.conf <<PORTS
Listen 8083
PORTS

  cat > /etc/apache2/sites-available/pi-heating-weather.conf <<VHOST
<VirtualHost *:8083>
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

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
