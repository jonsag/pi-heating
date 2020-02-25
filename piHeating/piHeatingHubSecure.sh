#!/bin/bash

#          Raspberry Pi setup, 'piHeatingHub' configuration script.
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


cd /home/pi

cat > /var/www/html/piHeatingHub/.htaccess <<ACCESS
AuthName "Secure Heating Hub"
AuthType Basic
AuthUserFile /home/pi/piHeatingHub/.htpasswd
require valid-user
ACCESS

printf "\n\n Password for user admin?\n"
htpasswd -c .htpasswd admin

mv /home/pi/.htpasswd /home/pi/piHeatingHub/.htpasswd
chmod 644 /home/pi/piHeatingHub/.htpasswd

printf "\n\n Installation Complete. \n\n"
exit 1
