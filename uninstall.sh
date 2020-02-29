#!/bin/bash

if [[ `whoami` != "root" ]]; then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi

########## piHeatingLCD ##########
printf "\n\n Uninstalling piHeatingLCD ..."

if [ -f /lib/systemd/system/gpio.service ]; then
	systemctl disable gpio.service
	rm /lib/systemd/system/gpio.service
	systemctl daemon-reload
fi

if [ -d /home/pi/piHeatingLCD ]; then
	rm -R /home/pi/piHeatingLCD
fi

########## piHeatingRemote ##########
printf "\n\n Uninstalling piHeatingRemote ..."

a2dissite piHeatingRemote.conf

if [ -f /etc/apache2/sites-available/piHeatingRemote.conf ]; then
	rm /etc/apache2/sites-available/piHeatingRemote.confg
fi

if [ $(cat /etc/apache2/ports.conf | grep 'Listen 8081' >> /dev/null)]; then
	sed '/Listen 8081/d' /etc/apache2/ports.conf
fi

if [ $(cat /boot/config.txt | grep dtoverlay=w1-gpio,gpiopin=14 >> /dev/null) ]; then
	printf "\n\nNot changing  /boot/config.txt"
else
		sed -i 's/dtoverlay=w1-gpio,gpiopin=14/dtoverlay=w1-gpio/g' /boot/config.txt
fi

if [ -d /var/www/html/piHeatingRemote ]; then
	rm -R /var/www/html/piHeatingRemote
fi

if [ -d /home/pi/piHeatingRemote ]; then
	rm -R /home/pi/piHeatingRemote
fi

########## database ##########
printf "\n\n Dropping database ..."

printf "\n\n\n Please enter the MySQL root password : "
read -s ROOT_PASSWORD

mysqladmin -u root -p$ROOT_PASSWORD drop piHeatingDB

########## piHeatingHub ##########
printf "\n\n Uninstalling piHeatingHub ..."

a2dissite piHeatingHub.conf

if [ -f /etc/apache2/sites-available/piHeatingHub.conf ]; then
	rm /etc/apache2/sites-available/piHeatingHub.confg
fi

if [ $(cat /etc/apache2/ports.conf | grep 'Listen 8080' >> /dev/null)]; then
	sed '/Listen 8080/d' /etc/apache2/ports.conf
fi

if [ -f /etc/cron.d/piHeating ]; then
	rm /etc/cron.d/piHeating
fi

if [ -d /var/www/html/piHeatingHub ]; then
	rm -R /var/www/html/piHeatingHub
fi

if [ -d /home/pi/piHeatingHub ]; then
	rm -R /home/pi/piHeatingHub
fi

service apache2 restart
