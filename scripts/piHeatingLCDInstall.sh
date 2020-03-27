#!/bin/bash

ARG1=$1
ARG2=$2

########## check for arguments
if [ ! $ARG1 ] || [ ! $ARG2]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	scriptDir=$ARG1
	installDir=$ARG2
fi

########## check for root
if [[ `whoami` != "root" ]]; then
  	echo -e "\n\n Error: \n Script must be run as root  \n Exiting ..."
  	exit 1
fi

########## check for piHeatinghub
if [ ! -f "$installDir/piHeatingHub/README.md" ]; then
  echo -e "\n\n First you must install piHeatingHub. \n Exiting ..."
  exit 1
fi

########## installation
########## install binaries
if [ ! -f "/home/pi/piHeatingLCD/README.md" ]; then
	if [ -d "/home/pi/piHeatingLCD" ]; then
		echo -e" Deleting old install ..."
		rm -rf "$installDir/piHeatingLCD"
	fi

	echo -e " Copying binaries ...\n"
	cp -rf "$scriptDir/pi-heating/piHeatingLCD/piHeatingLCD" "$installDir/"
  
	printf " Creating gpio-watch log file ..."
	touch $installDir/piHeatingLCD/gpio-watch.log
  
	echo -e " Setting permissions ...\n"
	chown -R pi:pi "$installDir/piHeatingLCD"
	chmod -R 750 "$installDir/piHeatingLCD"
	
	echo " Reloading service daemon ...\n"
	systemctl daemon-reload
	echo " Enabling gpio service ...\n"
	systemctl enable gpio.service

	if [ ! -f "$installDir/piHeatingLCD/README.md" ]; then
		echo "\n\n Error: \n piHeatingLCD installation failed \n"
		exit 1
	fi
else
	echo " piHeatingLCD is already installed. \n"
fi

########## setting up gpio-watch service
echo " Creating symlink for gpio service ...\n"
ln -s $installDir/piHeatingLCD/gpio.service /lib/systemd/system/gpio.service

echo -e " Setting permissions ...\n"
chmod 644 $installDir/piHeatingLCD/gpio.service

echo -e " Starting gpio service ..."
service gpio start

