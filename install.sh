#!/bin/bash

########## check for arguments
ARG1=$1

simulate=""
simulateMessage=" --- Simulation mode"

if [ $ARG1 ]; then
  	echo -e "\n\n Running with argument $1"
  	if [[ $ARG1 == "s" ]]; then
        simulate="1"
    fi
fi

########## directory of this script
scriptDir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

echo -e "\n\n Universal install for project piHeating"
echo -e " ----------"
echo -e " Run this script with argument 's' to simulate, \n nothing will be changed or installed."

########## check for root
if [[ `whoami` != "root" ]]; then
  	echo -e "\n\n Error:\n Script must be run as root."
  	if [ $simulate ]; then
  		echo -e "$simulateMessage, doesn't matter"
  	else
  		exit 1
  	fi
fi

########## check OS-version
OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"buster"* ]]; then
  	echo -e "\n\n Error:\n Script must be run on PI OS Buster."
  	if [ $simulate ]; then
  		echo -e "$simulateMessage, will run anyway"
  	else
  		exit 1
  	fi
fi

########## question: install piHeatingHub
while true; do
	echo -e "\n\n Do you wish to install piHeatingHub ?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n This is the base of it all, so you probably want this, \n unless this is a remote you will connect to a hub.";;
        [Nn] ) piHeatingHub=""; break;;
        * ) piHeatingHub="y"; break;;
    esac
done

########## question: secure piHeatingHub
while true; do
	echo -e "\n\n Do you wish to secure piHeatingHub web GUI?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n It's really a good idea to say yes to this, \n as it will require a password to log in to the web GUI.";;
        [Nn] ) piHeatingHubSecure=""; break;;
        * ) piHeatingHubSecure="y"; break;;
    esac
done

########## question: install piHeatingRemote
while true; do
	echo -e "\n\n Do you wish to install piHeatingRemote ?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n If you want to connect temperature sensors to the hub itself, \n or if this is a remote that will be used to get temperatures, \n say yes to this.";;
        [Nn] ) piHeatingRemote=""; break;;
        * ) piHeatingRemote="y"; break;;
    esac
done

########## question: install piHeatingLCD
while true; do
	echo -e "\n\n Do you wish to install piHeatingLCD ?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n If you have built the LCD shield, \n and will use it for visualization and control of the hub, \n say yes to this.";;
        [Nn] ) piHeatingLCD=""; break;;
        * ) piHeatingLCD="y"; break;;
    esac
done

########## question: install piPowerTempLog
while true; do
	echo -e "\n\n Do you wish to install piPowerTempLog ?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n If you have built the ardPowerTempLog Arduino to measure currents and power, \n or just want more logging, \n say yes to this.";;
        [Nn] ) piPowerTempLog=""; break;;
        * ) piPowerTempLog="y"; break;;
    esac
done

########## question: install piWeatherLog
while true; do
	echo -e "\n\n Do you wish to install piWeatherLog ?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n If you have built the ardWeatherStation to measure wind and rain, \n say yes to this.";;
        [Nn] ) piWeatherLog=""; break;;
        * ) piWeatherLog="y"; break;;
    esac
done

########## question: install handy progs
while true; do
	echo -e "\n\n Do you wish to install other handy programs ?"
    read -p " [Y/n/h]" input
    case $input in
    	[Hh] ) echo -e "\n Saying yes to this will install programs not really related to this, \n but I find them handy to have installed. \n These programs are: \n emacs: text editing at another level \n screen: nice way to run multiple shells \n locate: builds a fast searchable database of all files on this device";;
        [Nn] ) handy=""; break;;
        * ) handy="y"; break;;
    esac
done

########## view all before install
while true; do
	echo -e "\n\n"	
	echo -n "Install piHeatingHub "
	if [ $piHeatingHub ]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Secure piHeatingHub "
	if [ $piHeatingHubSecure ]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install piHeatingRemote "
	if [ $piHeatingHubSecure ]; then
	  	echo -e "\t OK"
	else
	  	echo -e "\t Skip"
	fi
	
	echo -n "Install piHeatingLCD "
	if [ $piHeatingLCD ]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install piPowerTempLog "
	if [ $piPowerTempLog ]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install piWeatherLog "
	if [ $piWeatherLog ]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install handy programs "
	if [ $handy ]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
########## final question
	echo -e "\n Is this correct ?"
    read -p " [Y/n]" input
    case $input in
        [Nn] ) install=""; "Exiting ..."; exit;;
        * ) install="y"; echo -e "\n\n Installing ..."; break;;
    esac
done

########## install everything

########## install prerequisites
echo -e "\n\n Installing prerequisites ... \n ----------"
if [ $simulate ]; then
  	echo -e "$simulateMessage, skipping install"
else
  	apt install git python-dev python-setuptools build-essential python-smbus python-pip rsync ttf-mscorefonts-installer -y
fi

########## install apache2
if [ piHeatingHub ]; then
	echo -e "\n\n Installing apache ... \n ----------"
	APACHE_INSTALLED=$(which apache2)
	if [[ "$APACHE_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install apache2 apache2-utils -y
	  		systemctl enable apache2
	  		a2dissite 000-default.conf
	  		service apache2 restart

	  		APACHE_INSTALLED=$(which apache2)
	    	if [[ "$APACHE_INSTALLED" == "" ]]; then
	      		echo -e "\n\n Error: \n Apache installation FAILED\n"
	      		exit 1
	    	fi
		fi
	else
	  	echo " Apache is already installed"
	fi
fi

########## install php
if [ piHeatingHub ]; then
	echo -e "\n\n Installing PHP ... \n ----------"
	PHP_INSTALLED=$(which php)
	if [[ "$PHP_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install php libapache2-mod-php php-common php-cli php-json php-readline -y

  			PHP_INSTALLED=$(which php)
    		if [[ "$PHP_INSTALLED" == "" ]]; then
      			echo -e "\n\n Error: \n PHP installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo " PHP is already installed"
	fi
fi

########## install sql
if [ piHeatingHub ]; then
	echo -e "\n\n Installing MariaDB ... \n ----------"
	SQL_INSTALLED=$(which mariadb)
	if [[ "$SQL_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install mariadb-server mariadb-client -y --fix-missing

  			SQL_INSTALLED=$(which mariadb)
    		if [[ "$SQL_INSTALLED" == "" ]]; then
      			echo -e "\n\n Error: \nMariaDB installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo "MariaDB is already installed"
	fi
fi

########## install php-mysql
if [ piHeatingHub ]; then
	echo -e "\n\n Installing MySQL PHP module ... \n ----------"
	PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
	if [[ "$PHPMYSQL_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install php-mysql -y

  			PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
    		if [[ "$PHPMYSQL_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n MySQL PHP module installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo " MySQL PHP module is already installed"
	fi
fi

########## install py-mysql
if [ piHeatingHub ]; then
	echo -e "\n\n Installing MySQL Python module ... \n ----------"
	PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
	if [[ "$PYMYSQL_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install python-mysqldb -y

  			PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
    		if [[ "$PYMYSQL_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n MySQL Python module installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo " MySQL Python module is already installed"
	fi
fi

########## install rrd-tool
if [ piHeatingHub ]; then
	echo -e "\n\n Installing RRD tool ... \n ----------"
	RRD_INSTALLED=$(find /var/lib/dpkg -name rrdtool*)
	if [[ "$RRD_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install rrdtool php-rrd -y

  			RRD_INSTALLED=$(find /var/lib/dpkg -name rrdtool*)
    		if [[ "$RRD_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n RRD tool installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo " RRD tool is already installed"
	fi
fi

########## install nmap
if [ piHeatingHub ]; then
	echo -e "\n\n Installing nmap ... \n ----------"
	NMP_INSTALLED=$(find /var/lib/dpkg -name nmap*)
	if [[ "$NMP_INSTALLED" == "" ]]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install nmap -y

	  		NMP_INSTALLED=$(find /var/lib/dpkg -name nmap*)
    		if [[ "$NMP_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n nmap installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo " nmap is already installed"
	fi
fi

########## install handy programs
if [ $handy ]; then
  	echo -e "\n\n Installing handy programs ... \n ----------"
  	if [ $simulate ]; then
  		echo -e "$simulateMessage, skipping install"
  	else
  		apt install emacs screen locate
  	fi
fi

########## install piHeatingHub
if [ piHeatingHub ]; then
	echo -e "\n\n Installing piHeatingHub ... \n ----------"
	if [ ! -f "/home/pi/piHeatingHub/README.md" ]; then
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		if [ -d "/home/pi/piHeatingHub" ]; then
		    	rm -rf "/home/pi/piHeatingHub"
		  	fi
		
		  	cp -rf "/home/pi/pi-heating/piHeating/piHeatingHub" "/home/pi/piHeatingHub"
		  	mv "/home/pi/piHeatingHub/www" "/var/www/piHeatingHub"
		  
		  	chown -R pi:www-data "/home/pi/piHeatingHub"
		  	chmod -R 750 "/home/pi/piHeatingHub"
		  
		  	if [ ! -d "/var/www/piHeatingHub/data" ]; then
		    	mkdir "/var/www/piHeatingHub/data"
		  	fi
		  
		  	mkdir "/home/pi/piHeatingHub/data"
		  	chown -R pi:www-data "/home/pi/piHeatingHub/data"
		  	chmod -R 775 "/home/pi/piHeatingHub/data"
		  
		  	chown -R pi:www-data "/var/www/piHeatingHub"
		  	chmod -R 755 "/var/www/piHeatingHub"
		  	chmod -R 775 "/var/www/piHeatingHub/images"

	  		if [ ! -f "/home/pi/piHeatingHub/README.md" ]; then
      			echo " Error: \n piHeatingHub installation FAILED\n"
      			exit 1
    		fi
		fi
	else
	  	echo " piHeatingHub is already installed"
	fi
fi
	

	

