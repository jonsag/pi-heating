#!/bin/bash

ARG1=$1
ARG2=$2
ARG3=$3

########## check for arguments
if [[ ! $ARG1 ]] || [[ ! $ARG2 ]]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	programs=$ARG1
	simulateMessage=$ARG2
	simulate=$ARG3
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

for program in $programs; do
	echo -e "\n\n Installing $program ... \n ----------"
	#if dpkg-query -l $program >> /dev/null 2>&1; then
	PKG_OK=$(dpkg-query -W --showformat='${Status}\n' $program | grep "install ok installed")
	if [ "" != "$PKG_OK" ]; then
		echo "     $program is already installed"
	else
		if [ $simulate ]; then
			echo "$simulateMessage"
		else
			apt install $program -y
		fi
		
		########## mariadb post installation
		if [ $program == "mariadb-server" ]; then
			echo -e "\n\n Running MariaDB post install ...\n ----------"
			mysql_secure_installation
			
			echo -e "\n\n Disabling MariaDB strict mode ... \n ----------"
			if [ -f "/etc/mysql/mariadb.conf.d/99-disable-strict-mode.cnf" ]; then
				echo "     Already in strict mode"
			else
				cat > /etc/mysql/mariadb.conf.d/99-disable-strict-mode.cnf <<STRICT
[server]
sql_mode = ""
STRICT
			fi
			
			echo -e "\n\n Enabling MariaDB ... \n ----------"
			systemctl enable mariadb
			
			echo -e "\n\n Restarting MariaDB ... \n ----------"
			service mariadb restart
		fi
		
		########## apache2 post installation
		if [ $program == "apache2" ]; then
			echo -e "\n\n Configuring Apache ... \n ----------"
			
			echo -e " Disabling Apache default site ..."
			a2dissite 000-default.conf
			
			echo -e " Enabling Apache ..."
			systemctl enable apache2
			
			echo -e " Starting Apache ..."
			service apache2 restart
		fi
		
		########## libapache2-mod-php post installation
		if [ $program == "libapache2-mod-php" ]; then
			echo -e "\n\n Enabling Apache PHP module ... \n ----------"
			a2enmod php7.3
		fi
	fi
done
	
	