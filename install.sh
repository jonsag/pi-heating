#!/bin/bash

########## check for arguments
ARG1=$1

########## simulation
simulate=""
simulateMessage=" --- Simulation mode"

######## database setup
DB_USERNAME='pi'
DB_PASSWORD=$(date | md5sum | head -c12)
DB_SERVER='localhost'
DB_NAME='piHeatingDB'

########## directory of this script
scriptDir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
########## install directory
installDir="$HOME/bin"

########## info
echo -e "\n\n Universal install for project piHeating"
echo -e " ----------"
echo -e " Run this script with argument 's' to simulate, \n nothing will be changed or installed."
echo -e "\n This scripts directory: $scriptDir"
if [ $ARG1 ]; then
  	echo -e "   Running with argument $1"
  	if [[ $ARG1 == "s" ]]; then
        simulate="1"
    fi
fi
echo -e " Install directory: $installDir"


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
	if [ $piHeatingRemote ]; then
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
        * ) install="y"; break;;
    esac
done

########## install everything
if [ ! $piHeatingHub ] && [ ! $piHeatingHubSecure ] && [ ! $piHeatingRemote ] && [ ! $piHeatingLCD ] && [ ! $piPowerTempLog ] && [ ! $piHeatingHubSecure ] && [ ! $piWeatherLog ] && [ ! $handy ]; then
	echo -e "\n\n Nothing selected \n Exiting ..."
	exit 0
else
	echo -e "\n\n Starting install ... \n ----------"
fi 

########## install prerequisites
if [ $piHeatingHub ] || [ $piHeatingHubSecure ] || [ $piHeatingRemote ] || [ $piHeatingLCD ] || [ $piPowerTempLog ] || [ $piHeatingHubSecure ] || [ $piWeatherLog ]; then
	echo -e "\n\n Installing prerequisites ... \n ----------"
	if [ $simulate ]; then
	  	echo -e "$simulateMessage, skipping install"
	else
	  	apt install git python-dev python-setuptools build-essential python-smbus python-pip rsync ttf-mscorefonts-installer -y
	fi
fi

########## install apache2
if [ $piHeatingHub ] || [ $piHeatingRemote ]; then
	echo -e "\n\n Installing apache ... \n ----------"
	if which apache2 >> /dev/null; then
		echo " Apache is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install apache2 apache2-utils -y
	  		systemctl enable apache2
	  		a2dissite 000-default.conf
	  		service apache2 restart

	  		APACHE_INSTALLED=$(which apache2)
	    	if [[ "$APACHE_INSTALLED" == "" ]]; then
	      		echo -e "\n\n Error: \n Apache installation failed\n"
	      		exit 1
	    	fi
		fi
	fi
fi

########## install php
if [ $piHeatingHub ] || [ $piHeatingRemote ]; then
	echo -e "\n\n Installing PHP ... \n ----------"
	if which php >> /dev/null; then
		echo " PHP is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install php libapache2-mod-php php-common php-cli php-json php-readline -y

  			PHP_INSTALLED=$(which php)
    		if [[ "$PHP_INSTALLED" == "" ]]; then
      			echo -e "\n\n Error: \n PHP installation failed\n"
      			exit 1
    		fi
		fi
	fi
fi

########## install sql
if [ $piHeatingHub ]; then
	echo -e "\n\n Installing MariaDB ... \n ----------"
	if which mariadb >> /dev/null; then
		echo "MariaDB is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install mariadb-server mariadb-client -y --fix-missing

  			SQL_INSTALLED=$(which mariadb)
    		if [[ "$SQL_INSTALLED" == "" ]]; then
      			echo -e "\n\n Error: \nMariaDB installation failed\n"
      			exit 1
    		fi
    		
    		echo -e "\n\n Running MariaDB post install ...\n ----------"
    		mysql_secure_installation
		fi
	fi
fi

########## install php-mysql
if [ $piHeatingHub ]; then
	echo -e "\n\n Installing MySQL PHP module ... \n ----------"
	if find /var/lib/dpkg -name php-mysql* >> /dev/null; then
		echo " MySQL PHP module is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install php-mysql -y

  			PHPMYSQL_INSTALLED=$(find /var/lib/dpkg -name php-mysql*)
    		if [[ "$PHPMYSQL_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n MySQL PHP module installation failed\n"
      			exit 1
    		fi
		fi	
	fi
fi

########## install py-mysql
if [ $piHeatingHub ]; then
	echo -e "\n\n Installing MySQL Python module ... \n ----------"
	if find /var/lib/dpkg -name python-mysql* >> /dev/null; then
		echo " MySQL Python module is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install python-mysqldb -y

  			PYMYSQL_INSTALLED=$(find /var/lib/dpkg -name python-mysql*)
    		if [[ "$PYMYSQL_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n MySQL Python module installation failed\n"
      			exit 1
    		fi
		fi
	fi
fi

########## install rrd-tool
if [ $piHeatingHub ]; then
	echo -e "\n\n Installing RRD tool ... \n ----------"
	if find /var/lib/dpkg -name rrdtool* >> /dev/null; then
		echo " RRD tool is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install rrdtool php-rrd -y

  			RRD_INSTALLED=$(find /var/lib/dpkg -name rrdtool*)
    		if [[ "$RRD_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n RRD tool installation failed\n"
      			exit 1
    		fi
		fi 	
	fi
fi

########## install nmap
if [ $piHeatingHub ]; then
	echo -e "\n\n Installing nmap ... \n ----------"
	if find /var/lib/dpkg -name nmap* >> /dev/null; then
		echo " nmap is already installed"
	else
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		apt install nmap -y

	  		NMP_INSTALLED=$(find /var/lib/dpkg -name nmap*)
    		if [[ "$NMP_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n nmap installation failed\n"
      			exit 1
    		fi
		fi	
	fi
fi

########## install python rpi.gpio
if [ $piHeatingLCD ]; then
	echo -e "\n\n Installing Python RPi.GPIO module ... \n ----------"
	if python -c "import RPi.GPIO" >> /dev/null 2>&1; then
		echo -e " RPi.GPIO is already installed"
	else
		if [ $simulate ]; then
		  	echo -e "$simulateMessage, skipping install"
		else
			pip install rpi.gpio
		fi		
	fi
fi

########## install adafruit char lcd
if [ $piHeatingLCD ]; then
	echo -e "\n\n Installing Python Adafruit_Python_CharLCD module ... \n ----------"
	if python -c "import Adafruit_CharLCD" >> /dev/null 2>&1; then
		echo -e " Adafruit_Python_CharLCD is already installed"
	else
		if [ $simulate ]; then
		  	echo -e "$simulateMessage, skipping install"
		else
			cd $scriptDir/Resources/Adafruit_Python_CharLCD
			python setup.py install
		fi		
	fi
fi

########## install gpio-watch
if [ $piHeatingLCD ]; then
	echo -e "\n\n Installing gpio-watch ... \n ----------"
	if which gpio-watch >> /dev/null; then
		echo " gpio-watch is already installed"
	else	
		if [ $simulate ]; then
  			echo -e "$simulateMessage, skipping install"
  		else
	  		cd $scriptDir/Resources/gpio-watch
	  		
	  		make  
			make install  
			
	  		NMP_INSTALLED=$(find /var/lib/dpkg -name nmap*)
    		if [[ "$NMP_INSTALLED" == "" ]]; then
      			echo "\n\n Error: \n gpio-watch installation failed\n"
      			exit 1
    		fi
		fi	
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

########## create ~/bin
if [ $piHeatingHub ] || [ $piHeatingHubSecure ] || [ $piHeatingRemote ] || [ $piHeatingLCD ] || [ $piPowerTempLog ] || [ $piHeatingHubSecure ] || [ $piWeatherLog ]; then
	echo -e "\n\n Creating installation directory ... \n ----------"
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping create"
	else
		if [ ! -d "$installDir" ]; then
			mkdir -p $installDir
		fi
	fi
fi

########## install piHeatingHub
if [ $piHeatingHub ]; then
	echo -e "\n\n Installing piHeatingHub ... \n ----------"
	if [ $simulate ]; then
  		echo -e "$simulateMessage, skipping install"
  	else
		$scriptDir/scripts/piHeatingHubInstall $scriptDir $installDir
	fi
fi

########## make piHeating Hub secure
if [ $piHeatingHubSecure ]; then
	echo -e "\n\n Securing piHeatingHub ... \n ----------"
	if [ $simulate ]; then
  		echo -e "$simulateMessage, skipping secure"
  	else
  		$scriptDir/scripts/piHeatingHubSecureInstall $scriptDir $installDir
	fi
fi

########## install piHeatingRemote
if [ $piHeatingRemote ]; then
	echo -e "\n\n Installing piHeatingRemote ... \n ----------"
	if [ $simulate ]; then
  		echo -e "$simulateMessage, skipping install"
  	else
		$scriptDir/scripts/piHeatingRemoteInstall $scriptDir $installDir
	fi
fi	

########## disable mariadb strict mode
if [ $piHeatingHub ]; then
	echo -e "\n\n Disabling MariaDB strict mode ... \n ----------"
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping disable"
	else
		if [ ! -f "/etc/mysql/mariadb.conf.d/99-disable-strict-mode.cnf" ]; then
	    	cat > /etc/mysql/mariadb.conf.d/99-disable-strict-mode.cnf <<STRICT
[server]
sql_mode = ""
STRICT
		fi
	fi

	echo -e "\n\n Restarting MariaDB ... \n ----------"
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping restart"
	else
		service mariadb restart
	fi
fi

########## configure apache
if [ $piHeatingHub ] || [ $piHeatingRemote ] || [ $piPowerTempLog ] || [ $piPowerWeatherLog ]; then
	echo -e "\n\n Enabling Apache PHP module ... \n ----------"
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping enable"
	else
		a2enmod php7.3
	fi

	echo -e "\n\n Restarting Apache ... \n ----------"
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping restart"
	else
		service apache2 restart
	fi
fi

########## restart cron
if [ $piHeatingHub ] || [ $piPowerTempLog ] || [ $piPowerWeatherLog ]; then
	echo -e "\n\n Restarting cron ... \n ----------"
	if [ $simulate ]; then
		echo -e "$simulateMessage, skipping restart"
	else
		service cron restart
	fi
fi
