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
echo -e " Checking piHeatingHub ..."
if [ ! "$installDir/piHeatingHub" ]; then
	"   Binaries does not exist"
	piHeatingHubError="y"		
fi
if [ ! /var/www/piHeatingHub ]; then
	echo "   WWW does not exist"
	piHeatingHubError="y"
fi
if [ ! -f "/etc/cron.d/piHeating" ]; then
	echo "   Cron does not exist"
	piHeatingHubError="y"
fi
if ! grep -Fxq 'Listen 8080' /etc/apache2/ports.conf >> /dev/null 2>&1; then
	echo "   Apache does not listen on port 8080"
	piHeatingHubError="y"
fi
if [ ! -f /etc/apache2/sites-available/piHeatingHub.conf ]; then
	echo "   No apache site installed"
	piHeatingHubError="y"
fi
if [ ! -f /etc/apache2/sites-enabled/piHeatingHub.conf ]; then
	echo "   No apache site enabled"
	piHeatingHubError="y"
fi
if [ ! -d /var/lib/mysql/piHeatingDB ]; then
	echo "   No database installed"
	piHeatingHubError="y"
fi	
if [ ! -f "$installDir/piHeatingHub/config/config.ini" ]; then
	echo "   No credential file exist"
	piHeatingHubError="y"
fi

########## piHeatingHubSecure
echo -e " Checking piHeatingHubSecure ..."
if [ ! -f $installDir/piHeatingHub/.htpasswd ]; then
	echo "   No .htpasswd file exists"
	piHeatingHubSecureError="y"
fi

########## piHeatingRemote
echo -e " Checking piHeatingRemote ..."
if [ ! "$installDir/piHeatingRemote" ]; then
	"   Binaries does not exist"
	piHeatingRemoteError="y"		
fi
if [ ! /var/www/piHeatingRemote ]; then
	echo "   WWW does not exist"
	piHeatingRemoteError="y"
fi
if ! grep -Fxq 'dtoverlay=w1-gpio,gpiopin=14' /boot/config.txt; then
	echo "   GPIO-pin 14 not set"
	piHeatingRemoteError="y"
fi
if ! grep -Fxq 'Listen 8081' /etc/apache2/ports.conf >> /dev/null 2>&1; then
	echo "   Apache does not listen on port 8081"
	piHeatingRemoteError="y"
fi
if [ ! -f /etc/apache2/sites-available/piHeatingRemote.conf ]; then
	echo "   No apache site installed"
	piHeatingRemoteError="y"
fi
if [ ! -f /etc/apache2/sites-enabled/piHeatingRemote.conf ]; then
	echo "   No apache site enabled"
	piHeatingRemoteError="y"
fi

########## piHeatingLCD
echo -e " Checking piHeatingLCD ..."
if [ ! "$installDir/piHeatingLCD" ]; then
	"   Binaries does not exist"
	piHeatingLCDError="y"		
fi
if ! grep -Fxq 'dtoverlay=w1-gpio,gpiopin=14' /boot/config.txt; then
	echo "   GPIO-pin 14 not set"
	piHeatingLCDError="y"
fi
if [ ! -L /lib/systemd/system/gpio.service ]; then
	echo "   Link to service does not exist"
	piHeatingLCDError="y"
fi


########## piPowerTempLog
echo -e " Checking piPowerTempLog ..."
if [ ! "$installDir/piPowerTempLog" ]; then
	"   Binaries does not exist"
	piPowerTempLogError="y"		
fi
if [ ! /var/www/piPowerTempLog ]; then
	echo "   WWW does not exist"
	piPowerTempLogError="y"
fi
if [ ! -f "/etc/cron.d/piPowerTempLog" ]; then
	echo "   Cron does not exist"
	piPowerTempLogError="y"
fi
if ! grep -Fxq 'Listen 8082' /etc/apache2/ports.conf >> /dev/null 2>&1; then
	echo "   Apache does not listen on port 8082"
	piPowerTempLogError="y"
fi
if [ ! -f /etc/apache2/sites-available/piPowerTempLog.conf ]; then
	echo "   No apache site installed"
	piPowerTempLogError="y"
fi
if [ ! -f /etc/apache2/sites-enabled/piPowerTempLog.conf ]; then
	echo "   No apache site enabled"
	piPowerTempLogError="y"
fi
if [ ! -d /var/lib/mysql/piHeatingDB ]; then
	echo "   No database installed"
	piPowerTempLogError="y"
fi

##########  piWeatherLog
echo -e " Checking piWeatherLog ..."
if [ ! "$installDir/piWeatherLog" ]; then
	"   Binaries does not exist"
	piWeatherLogError="y"		
fi
if [ ! /var/www/piWeatherLog ]; then
	echo "   WWW does not exist"
	piWeatherLogError="y"
fi
if [ ! -f "/etc/cron.d/piWeatherLog" ]; then
	echo "   Cron does not exist"
	piWeatherLogError="y"
fi
if ! grep -Fxq 'Listen 8083' /etc/apache2/ports.conf >> /dev/null 2>&1; then
	echo "   Apache does not listen on port 8083"
	piWeatherLogError="y"
fi
if [ ! -f /etc/apache2/sites-available/piWeatherLog.conf ]; then
	echo "   No apache site installed"
	piWeatherLogError="y"
fi
if [ ! -f /etc/apache2/sites-enabled/piWeatherLog.conf ]; then
	echo "   No apache site enabled"
	piWeatherLogError="y"
fi
if [ ! -d /var/lib/mysql/piHeatingDB ]; then
	echo "   No database installed"
	piPowerTempLogError="y"
fi

##########  conclusion
if [ $piHeatingHubError ]  || [ $piHeatingHubSecureError ]|| [ $piHeatingRemoteError ] || [ $piHeatingLCDError ] || [ $piPowerLogError ] || [ $piWeatherLogError ]; then
	echo -e "\n Error: "
else
	echo -e "\n OK! \n Everything installed"
fi




