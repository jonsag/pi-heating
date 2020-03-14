#!/bin/bash

if [[ `whoami` != "root" ]]; then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi

########## piHeatingExtendedLog ##########
printf "\n\n Uninstalling piHeatingRemote ... \n"

printf "Disabling site ... \n"
if [ -f /etc/apache2/sites-enabled/piHeatingExtendedLog.conf ]; then
	a2dissite piHeatingExtendedLog.conf
else
	printf "    Not enabled \n"
fi

printf "Deleting site configuration... \n"
if [ -f /etc/apache2/sites-available/piHeatingExtendedLog.conf ]; then
	rm /etc/apache2/sites-available/piHeatingExtendedLog.conf
else
	printf "    Not present \n"
fi

printf "Removing listening directives ... \n"
if grep -Fxq 'Listen 8082' /etc/apache2/ports.conf; then
	sed -i '/Listen 8082/d' /etc/apache2/ports.conf
else
	printf "    Not present \n"	
fi

printf "Deleting site ... \n"
if [ -d /var/www/piHeatingExtendedLog ]; then
	rm -R /var/www/piHeatingExtendedLog
else
	printf "    Not present \n"
fi

printf "Deleting executables ... \n"
if [ -d /home/pi/piHeatingExtendedLog ]; then
	rm -R /home/pi/piHeatingExtendedLog
else
	printf "    Not present \n"
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
if [ -f /etc/apache2/sites-enabled/piHeatingRemote.conf ]; then
	a2dissite piHeatingRemote.conf
else
	printf "    Not enabled \n"
fi

printf "Deleting site configuration... \n"
if [ -f /etc/apache2/sites-available/piHeatingRemote.conf ]; then
	rm /etc/apache2/sites-available/piHeatingRemote.conf
else
	printf "    Not present \n"
fi

printf "Removing listening directives ... \n"
if grep -Fxq 'Listen 8081' /etc/apache2/ports.conf; then
	sed -i '/Listen 8081/d' /etc/apache2/ports.conf
else
	printf "    Not present \n"	
fi

printf "Changing boot parameters ... \n"
if grep -Fxq 'dtoverlay=w1-gpio,gpiopin=14' /boot/config.txt; then
	sed -i 's/dtoverlay=w1-gpio,gpiopin=14/dtoverlay=w1-gpio/g' /boot/config.txt
else
	printf "    Not necessary\n"
fi

printf "Deleting site ... \n"
if [ -d /var/www/piHeatingRemote ]; then
	rm -R /var/www/piHeatingRemote
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
	printf " Please enter the MySQL root password : \n"
	read -s ROOT_PASSWORD
	printf "Deleting database ... \n"
	#mysqladmin -u root -p$ROOT_PASSWORD drop piHeatingDB
	
mysql -uroot -p$ROOT_PASSWORD<< DELETE
	
DROP USER IF EXISTS 'pi'@localhost;
DROP DATABASE IF EXISTS piHeatingDB;
	
DELETE
	
else
	printf "    Not present \n"
fi

########## piHeatingHub ##########
printf "\n\n Uninstalling piHeatingHub ... \n"

printf "Disabling site ... \n"
if [ -f /etc/apache2/sites-enabled/piHeatingHub.conf ]; then
	a2dissite piHeatingHub.conf
else
	printf "    Not enabled \n"
fi


printf "Deleting site configuration ... \n"
if [ -f /etc/apache2/sites-available/piHeatingHub.conf ]; then
	rm /etc/apache2/sites-available/piHeatingHub.conf
else
	printf "    Not present \n"
fi

printf "Deleting listening directives ... \n"
if grep -Fxq 'Listen 8080' /etc/apache2/ports.conf; then
	sed -i '/Listen 8080/d' /etc/apache2/ports.conf
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
if [ -d /var/www/piHeatingHub ]; then
	rm -R /var/www/piHeatingHub
else
	printf "    Not present \n"
fi

printf "Deleting executables ... \n"
if [ -d /home/pi/piHeatingHub ]; then
	rm -R /home/pi/piHeatingHub
else
	printf "    Not present \n"
fi

printf "\n\n Restarting apache ... \n"
if [ $( systemctl is-active --quiet apache2 ) ]; then
	printf "    Service is not runnning \n"
else
	service apache2 restart
fi
