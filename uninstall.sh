#!/bin/bash

if [[ `whoami` != "root" ]]; then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi

########## piHeatingLCD ##########
printf "\n\n Uninstalling piHeatingLCD ... \n"

printf "Disabling service ...\n"
if [ -f /lib/systemd/system/gpio.service ]; then
	systemctl disable gpio.service
	rm /lib/systemd/system/gpio.service
	systemctl daemon-reload
else
	printf "    No service installed \n"
fi

printf "Deleting executables ... \n"
if [ -d /home/pi/piHeatingLCD ]; then
	rm -R /home/pi/piHeatingLCD
else
	printf "    Not present \n"
fi

########## piHeatingRemote ##########
printf "\n\n Uninstalling piHeatingRemote ... \n"

printf "Disabling site ... \n"
a2dissite piHeatingRemote.conf

printf "Deleting site configuration... \n"
if [ -f /etc/apache2/sites-available/piHeatingRemote.conf ]; then
	rm /etc/apache2/sites-available/piHeatingRemote.conf
else
	printf "    Not present \n"
fi

printf "Removing listening directives ... \n"
if [ $(cat /etc/apache2/ports.conf | grep 'Listen 8081' >> /dev/null)]; then
	sed '/Listen 8081/d' /etc/apache2/ports.conf
else
	printf "    Not present \n"
fi

printf "Changing boot parameters ... \n"
if [ $(cat /boot/config.txt | grep dtoverlay=w1-gpio,gpiopin=14 >> /dev/null) ]; then
	sed -i 's/dtoverlay=w1-gpio,gpiopin=14/dtoverlay=w1-gpio/g' /boot/config.txt
else
	printf "    Not necessary\n"
fi

printf "Deleting site ... \n"
if [ -d /var/www/html/piHeatingRemote ]; then
	rm -R /var/www/html/piHeatingRemote
else
	printf "    Not present \n"
fi

printf "Deleting executables ... \n"
if [ -d /home/pi/piHeatingRemote ]; then
	rm -R /home/pi/piHeatingRemote
else
	printf "    Not present \n"
fi

########## database ##########
printf "\n\n Dropping database ... \n"

if [ -d /var/lib/mysql/piHeatingDB ]; then
	printf " Please enter the MySQL root password : "
	read -s ROOT_PASSWORDprintf "Deleting database ... \n"
	mysqladmin -u root -p$ROOT_PASSWORD drop piHeatingDB	
else
	printf "    Not present \n"
fi

########## piHeatingHub ##########
printf "\n\n Uninstalling piHeatingHub ... \n"

printf "Disabling site ... \n"
a2dissite piHeatingHub.conf

printf "Deleting site configuration ... \n"
if [ -f /etc/apache2/sites-available/piHeatingHub.conf ]; then
	rm /etc/apache2/sites-available/piHeatingHub.conf
else
	printf "    Not present \n"
fi

printf "Deleting listening directives ... \n"
if [ $(cat /etc/apache2/ports.conf | grep 'Listen 8080' >> /dev/null)]; then
	sed '/Listen 8080/d' /etc/apache2/ports.conf
else
	printf "    Not present \n"
fi

printf "Removing cron jobs ... \n"
if [ -f /etc/cron.d/piHeating ]; then
	rm /etc/cron.d/piHeating
else
	printf "    Not present \n"
fi

printf "Deleting site ... \n"
if [ -d /var/www/html/piHeatingHub ]; then
	rm -R /var/www/html/piHeatingHub
else
	printf "    Not present \n"
fi

printf "Deleting executables ... \n"
if [ -d /home/pi/piHeatingHub ]; then
	rm -R /home/pi/piHeatingHub
else
	printf "    Not present \n"
fi

printf "Restarting apache ... \n"
service apache2 restart
