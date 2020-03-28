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
echo -e "\n\n Installing piHeatingRemote ... \n ----------"

########## check for piHeatingHub
while true; do
	echo -e "\n Check for piHeatingHub \n Please enter IP of piHeatingHub "
	read -p " [<ip>/LOCALHOST/[s]kip] " hubIP

	if [[ $hubIP == "S" ]] || [[ $hubIP == "s" ]]; then
		echo -e " Skipping check of piHeatingHub"
		break;
	elif [ ! $hubIP ]; then
		echo -e "\n Checking if localhost has piHeatingHub ..."
		if [ -f "$installDir/piHeatingHub/README.md" ]; then
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
echo
if [ -f "$installDir/piHeatingRemote/README.md" ]; then
	echo "     piHeatingRemote is already installed"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		if [ -d "$installDir/piHeatingRemote" ]; then
			echo -e " Deleting old install ..."
			rm -rf "$installDir/piHeatingRemote"
		fi
	
		echo -e " Copying binaries ..."
		cp -rf "$scriptDir/piHeating/piHeatingRemote" "$installDir/"
		
		echo -e " Moving web ..."
		mv "$installDir/piHeatingRemote/www" "/var/www/piHeatingRemote"
	  
	  	echo -e " Setting permissions ..."
		chown -R pi:pi "$installDir/piHeatingRemote"
		chmod -R 755 "$installDir/piHeatingRemote"
	  
		chown -R pi:pi "$installDir/piHeatingRemote/configs"
		chmod -R 755 "$installDir/piHeatingRemote/configs"
	  
		chown -R pi:www-data "/var/www/piHeatingRemote"
		chmod -R 755 "/var/www/piHeatingRemote"
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

########## configure apache
echo -e " Setting Apache listen port 8081 ..."
if grep -Fxq 'Listen 8081' /etc/apache2/ports.conf; then
	echo "     Apache already listening on port 8081"
else
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		cat >> /etc/apache2/ports.conf <<PORTS
Listen 8081
PORTS
	fi
fi

########## add apache site
echo -e " Adding site ..."
if [ -f /etc/apache2/sites-available/piHeatingRemote.conf ]; then
	echo "     Site already exists"
else
	if [ $simulate ]; then
	  	echo "$simulateMessage"
	else
		cat > /etc/apache2/sites-available/piHeatingRemote.conf <<VHOST
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
	fi
fi

########## enable site
echo -e " Enabling site ..."
if [ $simulate ]; then
  	echo "$simulateMessage"
else
	a2ensite piHeatingRemote.conf
fi





