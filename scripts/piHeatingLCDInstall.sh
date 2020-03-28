#!/bin/bash

ARG1=$1
ARG2=$2

########## check for arguments
if [ ! $ARG1 ] || [ ! $ARG2 ]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	scriptDir=$ARG1
	installDir=$ARG2
fi

########## check for root
if [[ `whoami` != "root" ]]; then
	echo -e "\n\n Error: \n Script must be run as root  \n Exiting ..."
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		exit 1
	fi
fi

########## check for piHeatinghub
if [ ! -f "$installDir/piHeatingHub/README.md" ]; then
  echo -e "\n\n First you must install piHeatingHub. \n Exiting ..."
  exit 1
fi

########## installation
echo -e "\n\n Installing piHeatingLCD ... \n ----------"

########## install binaries
if [ -f "$installDir/piHeatingLCD/README.md" ]; then
	echo "     piHeatingLCD is already installed"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		if [ -d "$installDir/piHeatingLCD" ]; then
			echo -e" Deleting old install ..."
			rm -rf "$installDir/piHeatingLCD"
		fi
	
		echo -e " Copying binaries ..."
		cp -rf "$scriptDir/piHeatingLCD/piHeatingLCD" "$installDir/"
	  
		echo " Creating gpio-watch log file ..."
		touch "$installDir/piHeatingLCD/gpio-watch.log"
	  
		echo -e " Setting permissions ..."
		chown -R pi:pi "$installDir/piHeatingLCD"
		chmod -R 750 "$installDir/piHeatingLCD"
	fi
fi

########## change GPIO pin for 1-wire sensors
echo -e " Setting GPIO-pin for 1-wire sensors ..."
if grep -Fxq 'dtoverlay=w1-gpio,gpiopin=14' /boot/config.txt; then
		echo -e "     Already set"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		sed -i 's/dtoverlay=w1-gpio/dtoverlay=w1-gpio,gpiopin=14/g' /boot/config.txt
	fi
fi

########## setting up gpio-watch service	
echo " Creating symlink for gpio service ..."
if [ -L /lib/systemd/system/gpio.service ]; then
	echo "     Link already exists"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		ln -s "$installDir/piHeatingLCD/gpio.service" /lib/systemd/system/gpio.service
		
		echo -e " Setting permission ..."
		chmod 644 "$installDir/piHeatingLCD/gpio.service"
	fi
fi

echo " Reloading service daemon ..."
if [ $simulate ]; then
	echo "$simulateMessage"
else
	systemctl daemon-reload
fi

echo " Enabling gpio service ..."
if [ $simulate ]; then
	echo "$simulateMessage"
else
	systemctl enable gpio.service
fi

echo -e " Starting gpio service ..."
if [ $simulate ]; then
	echo "$simulateMessage"
else
	service gpio start
fi









