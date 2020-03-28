#!/bin/bash

ARG1=$1

########## check for arguments
if [ ! $ARG1 ]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	scriptDir=$ARG1
fi

########## read config
. $scriptDir/scripts/config.ini

echo -e "\n\n Running post install check \n ----------"

########## piHeatingHub
echo " Checking piHeatingHub"
if [ $installDir/piHeatingHub ]; then
	echo "   Binaries directory exist"
else
	piHeatingHubError="y"
fi

########## piHeatingHubSecure
echo " Checking piHeatingHubSecure"
if [ $installDir/piHeatingHub ]; then
	echo "   Binaries directory exist"
else
	piHeatingHubSecureError="y"
fi
########## piHeatingRemote
echo " Checking piHeatingRemote"
if [ $installDir/piHeatingRemote ]; then
	echo "   Binaries directory exist"
else
	piHeatingRemoteError="y"
fi

########## piHeatingLCD
echo " Checking piHeatingLCD"
if [ $installDir/piHeatingLCD ]; then
	echo "   Binaries directory exist"
else
	piHeatingLCDError="y"
fi

########## piPowerTempLog
echo " Checking piPowerTempLog"
if [ $installDir/piPowerTempLog ]; then
	echo "   Binaries directory exist"
else
	piPowerTempLogError="y"
fi

##########  piWeatherLog
echo " Checking piWeatherLog"
if [ $installDir/piWeatherLog ]; then
	echo "   Binaries directory exist"
else
	piWeatherLogError="y"
fi

##########  conclusion
if [ $piHeatingHubError ]  || [ $piHeatingHubSecureError ]|| [ $piHeatingRemoteError ] || [ $piHeatingLCDError ] || [ $piPowerLogError ] || [ $piWeatherLogError ]; then
	echo -e "\n\n Error: "
else
	echo -e "\n\n Everything installed"
fi




