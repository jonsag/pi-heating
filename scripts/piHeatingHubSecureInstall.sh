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

########## installation
if [ $simulate ]; then
	echo "$simulateMessage"
else
	echo -e " Creating .htaccess file ..."
	cat > /var/www/piHeatingHub/.htaccess <<ACCESS
AuthName "Secure Heating Hub"
AuthType Basic
AuthUserFile $installDir/piHeatingHub/.htpasswd
require valid-user
ACCESS
	
	echo -e " Enter password for user 'admin' ?"
	htpasswd -c $installDir/piHeatingHub/.htpasswd admin
	
	chmod 644 $installDir/piHeatingHub/.htpasswd
fi


