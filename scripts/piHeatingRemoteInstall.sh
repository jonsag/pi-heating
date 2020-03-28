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
  	echo -e "\n\n Error: \n Script must be run as root \n Exiting ..."
  	exit 1
fi

########## installation
########## check for piHeatingHub
while true; do
	echo -e " Please enter IP of piHeatingHub "
	read -p " [<ip>/LOCALHOST/[s]kip] " hubIP

	if [[ $hubIP == "S" ]] || [[ $hubIP == "s" ]]; then
		echo -e " Skipping check of piHeatingHub"
		break;
	elif [ ! $hubIP ]; then
		echo -e "\n Checking if localhost has piHeatingHub ..."
		if [ -f "/home/pi/bin/piHeatingHub/README.md" ]; then
			break
		else
			echo -e " Could not find piHeatingHub at localhost \n"
		fi
	else
		echo -e "\n Testing if '$hubIP' runs a piHeatingHub ..."
		if curl -s --head http://$hubIP:8080 | sed -n 4p | grep 'Secure Heating Hub' > /dev/null; then
			break
		else
			echo -e " Could not find a piHeatingHub at $hubIP \n"
		fi
	fi
done

########## install binaries and web
if [ ! -f "/home/pi/piHeatingRemote/README.md" ]; then
	if [ -d "$installDir/piHeatingRemote" ]; then
		echo -e " Deleting old directory ..."
		rm -rf "$installDir/piHeatingRemote"
	fi

	echo -e " Copying binaries ..."
	cp -rf "$scriptDir/pi-heating/piHeating/piHeatingRemote" "$installDir/piHeatingRemote"
	echo -e " Moving web ..."
	mv "$installDir/piHeatingRemote/www" "/var/www/piHeatingRemote"
  
  	echo -e " Setting permissions ..."
	chown -R pi:pi "$installDir/piHeatingRemote"
	chmod -R 755 "$installDir/piHeatingRemote"
  
	chown -R pi:pi "$installDir/piHeatingRemote/configs"
	chmod -R 755 "$installDir/piHeatingRemote/configs"
  
	chown -R pi:www-data "/var/www/piHeatingRemote"
	chmod -R 755 "/var/www/piHeatingRemote"
  
	if [ ! -f "$installDir/piHeatingRemote/README.md" ]; then
		printf "\n\n Error: \n piHeatingRemote installation failed\n"
		exit 1
	fi
    
else
	echo " piHeatingRemote is already installed"
fi

########## change GPIO pin for 1-wire sensors
echo -e " Setting GPIO-pin for 1-wire sensors ..."
if grep -Fxq 'dtoverlay=w1-gpio,gpiopin=14' /boot/config.txt; then
		echo -e "   Already set"
else
	sed -i 's/dtoverlay=w1-gpio/dtoverlay=w1-gpio,gpiopin=14/g' /boot/config.txt
fi

########## configure apache
echo -e " Setting Apache listen port 8081 ..."
if grep -Fxq 'Listen 8081' /etc/apache2/ports.conf; then
	printf "   Apache already listening on port 8081 \n"
else
	cat >> /etc/apache2/ports.conf <<PORTS
Listen 8080
PORTS
fi

########## add apache site
echo -e " Adding site ..."
cat > /etc/apache2/sites-available/piHeatingHub.conf <<VHOST
<VirtualHost *:8081>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/piHeatingRemote/

    <Directory /var/www/piHeatingRemote/>
        Options -Indexes
        AllowOverride all
        Order allow,deny
        allow from all
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
VHOST

echo -e " Enabling site ..."
a2ensite piHeatingRemote.conf






