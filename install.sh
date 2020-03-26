#!/bin/bash

########## check for arguments
ARG1=$1
if [ $ARG1 ]; then
  	echo -e "\n\n Running with argument $1"
fi

echo -e "\n\n Universal install for project piHeating"
echo -e " ----------"

########## check for root
if [[ `whoami` != "root" ]]; then
  	echo -e "\n\n Error:\n Script must be run as root."
  	if [[ $ARG1 == "s" ]]; then
  		echo " ---- Simulation mode"
  	else
  		exit 1
  	fi
fi

########## check OS-version
OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"buster"* ]]; then
  	echo -e "\n\n Error:\n Script must be run on PI OS Buster."
  	if [[ $ARG1 == "s" ]]; then
  		echo " ---- Simulation mode"
  	else
  		exit 1
  	fi
fi

########## question: install piHeatingHub
while true; do
	echo -e "\n\n Do you wish to install piHeatingHub ?"
    read -p " [Y/n/h]" piHeatingHub
    case $piHeatingHub in
    	[Hh] ) echo -e "\n This is the base of it all, so you probably want this, \n unless this is a remote you will connect to a hub.";;
        [Nn] ) break;;
        * ) piHeatingHub="y"; break;;
    esac
done

########## question: secure piHeatingHub
while true; do
	echo -e "\n\n Do you wish to secure piHeatingHub web GUI?"
    read -p " [Y/n/h]" piHeatingHubSecure
    case $piHeatingHubSecure in
    	[Hh] ) echo -e "\n It's really a good idea to say yes to this, \n as it will require a password to log in to the web GUI.";;
        [Nn] ) break;;
        * ) piHeatingHubSecure="y"; break;;
    esac
done

########## question: install piHeatingRemote
while true; do
	echo -e "\n\n Do you wish to install piHeatingRemote ?"
    read -p " [Y/n/h]" piHeatingRemote
    case $piHeatingRemote in
    	[Hh] ) echo -e "\n If you want to connect temperature sensors to the hub itself, \n or if this is a remote that will be used to get temperatures, \n say yes to this.";;
        [Nn] ) break;;
        * ) piHeatingRemote="y"; break;;
    esac
done

########## question: install piHeatingLCD
while true; do
	echo -e "\n\n Do you wish to install piHeatingLCD ?"
    read -p " [Y/n/h]" piHeatingLCD
    case $piHeatingLCD in
    	[Hh] ) echo -e "\n If you have built the LCD shield, \n and will use it for visualization and control of the hub, \n say yes to this.";;
        [Nn] ) break;;
        * ) piHeatingLCD="y"; break;;
    esac
done

########## question: install piPowerTempLog
while true; do
	echo -e "\n\n Do you wish to install piPowerTempLog ?"
    read -p " [Y/n/h]" piPowerTempLog
    case $piPowerTempLog in
    	[Hh] ) echo -e "\n If you have built the ardPowerTempLog Arduino to measure currents and power, \n or just want more logging, \n say yes to this.";;
        [Nn] ) break;;
        * ) piPowerTempLog="y"; break;;
    esac
done

########## question: install piWeatherLog
while true; do
	echo -e "\n\n Do you wish to install piWeatherLog ?"
    read -p " [Y/n/h]" piWeatherLog
    case $piWeatherLog in
    	[Hh] ) echo -e "\n If you have built the ardWeatherStation to measure wind and rain, \n say yes to this.";;
        [Nn] ) break;;
        * ) piWeatherLog="y"; break;;
    esac
done

########## question: install handy progs
while true; do
	echo -e "\n\n Do you wish to install other handy programs ?"
    read -p " [Y/n/h]" handy
    case $handy in
    	[Hh] ) echo -e "\n Saying yes to this will install programs not really related to this, \n but I find them handy to have installed. \n These programs are: \n emacs: text editing at another level \n screen: nice way to run multiple shells \n locate: builds a fast searchable database of all files on this device";;
        [Nn] ) break;;
        * ) handy="y"; break;;
    esac
done

########## view all before install
while true; do
	echo -e "\n\n"	
	echo -n "Install piHeatingHub "
	if [[ $piHeatingHub == "y" ]]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Secure piHeatingHub "
	if [[ $piHeatingHubSecure == "y" ]]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install piHeatingRemote "
	if [[ $piHeatingHubSecure == "y" ]]; then
	  	echo -e "\t OK"
	else
	  	echo -e "\t Skip"
	fi
	
	echo -n "Install piHeatingLCD "
	if [[ $piHeatingLCD == "y" ]]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install piPowerTempLog "
	if [[ $piPowerTempLog == "y" ]]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install piWeatherLog "
	if [[ $piWeatherLog == "y" ]]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
	echo -n "Install handy programs "
	if [[ $handy == "y" ]]; then
	  	echo -e "\t\t OK"
	else
	  	echo -e "\t\t Skip"
	fi
	
########## final question
	echo -e "\n Is this correct ?"
    read -p " [Y/n]" installing
    case $installing in
        [Nn] ) "Exiting ..."; exit;;
        * ) install="y"; echo -e "\n\n Installing ..."; break;;
    esac
done

########## install everything

########## install prerequisites
echo -e "\n\n Installing prerequisites ... \n ----------"
if [[ $ARG1 == "s" ]]; then
  	echo " ---- Simulation mode"
else
  	apt install git python-dev python-setuptools build-essential python-smbus python-pip rsync ttf-mscorefonts-installer
fi

########## install handy programs
if [[ $handy == "y" ]]; then
  	echo -e "\n\n Installing handy programs ... \n ----------"
  	if [[ $ARG1 == "s" ]]; then
  		echo " ---- Simulation mode"
  	else
  		apt install emacs screen locate
  	fi
fi

