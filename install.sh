#!/bin/bash

########## check for arguments
ARG1=$1

########## simulation
simulateMessage="    --- Simulation"
simulate=""

########## directory of this script
scriptDir="$(cd "$(dirname "${BASH_SOURCE[0]}")" >/dev/null 2>&1 && pwd)"

########## read config
. $scriptDir/scripts/config.ini

########## info
echo -e "\n\n Universal install for project piHeating"
echo -e " ----------"
echo -e "\n Run this script with argument 's' to simulate, \n nothing will be changed or installed."
echo -e "\n This scripts directory: $scriptDir"
if [ $ARG1 ]; then
	echo -e "     Running with argument $1"
	if [[ $ARG1 == "s" ]]; then
		simulate="1"
	fi
fi
echo -e " Install directory: $installDir"

########## check for root
if [[ $(whoami) != "root" ]]; then
	echo -e "\n\n Error:\n Script must be run as root."
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		exit 1
	fi
fi

########## check OS-version
OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"buster"* ]]; then
	echo -e "\n\n Error:\n Script must be run on PI OS Buster."
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		exit 1
	fi
fi

########## question: install piHeatingHub
while true; do
	echo -e "\n\n Do you wish to install piHeatingHub ?"
	read -p " [Y/n/h] " input
	case $input in
	[Hh]) echo -e "\n This is the base of it all, so you probably want this, \n unless this is a remote you will connect to a hub." ;;
	[Nn])
		piHeatingHub=""
		break
		;;
	*)
		piHeatingHub="y"
		break
		;;
	esac
done

########## question: secure piHeatingHub
#while true; do
#	echo -e "\n\n Do you wish to secure piHeatingHub web GUI?"
#    read -p " [Y/n/h] " input
#    case $input in
#    	[Hh] ) echo -e "\n It's really a good idea to say yes to this, \n as it will require a password to log in to the web GUI.";;
#        [Nn] ) piHeatingHubSecure=""; break;;
#        * ) piHeatingHubSecure="y"; break;;
#    esac
#done
if [ $piHeatingHub ]; then
	piHeatingHubSecure="y"
fi

########## question: install piHeatingRemote
while true; do
	echo -e "\n\n Do you wish to install piHeatingRemote ?"
	read -p " [Y/n/h] " input
	case $input in
	[Hh]) echo -e "\n If you want to connect temperature sensors to the hub itself, \n or if this is a remote that will be used to get temperatures, \n say yes to this." ;;
	[Nn])
		piHeatingRemote=""
		break
		;;
	*)
		piHeatingRemote="y"
		break
		;;
	esac
done

########## question: install piHeatingLCD
while true; do
	echo -e "\n\n Do you wish to install piHeatingLCD ?"
	read -p " [Y/n/h] " input
	case $input in
	[Hh]) echo -e "\n If you have built the LCD shield, \n and will use it for visualization and control of the hub, \n say yes to this." ;;
	[Nn])
		piHeatingLCD=""
		break
		;;
	*)
		piHeatingLCD="y"
		break
		;;
	esac
done

########## question: install piPowerTempLog
while true; do
	echo -e "\n\n Do you wish to install piPowerTempLog ?"
	read -p " [Y/n/h] " input
	case $input in
	[Hh]) echo -e "\n If you have built the ardPowerTempLog Arduino to measure currents and power, \n or just want more logging, \n say yes to this." ;;
	[Nn])
		piPowerTempLog=""
		break
		;;
	*)
		piPowerTempLog="y"
		break
		;;
	esac
done

########## question: install piWeatherLog
while true; do
	echo -e "\n\n Do you wish to install piWeatherLog ?"
	read -p " [Y/n/h] " input
	case $input in
	[Hh]) echo -e "\n If you have built the ardWeatherStation to measure wind and rain, \n say yes to this." ;;
	[Nn])
		piWeatherLog=""
		break
		;;
	*)
		piWeatherLog="y"
		break
		;;
	esac
done

########## question: install handy progs
while true; do
	echo -e "\n\n Do you wish to install other handy programs ?"
	read -p " [Y/n/h] " input
	case $input in
	[Hh])
		echo -e "\n Saying yes to this will install programs not really related to this, \n but I find them handy to have installed. \n These programs are: "
		for program in $handyPrograms; do echo " $program"; done
		;;
	[Nn])
		handy=""
		break
		;;
	*)
		handy="y"
		break
		;;
	esac
done

########## view all before install
while true; do
	echo -e "\n\n Summary \n ----------"
	echo -n " Install piHeatingHub "
	if [ $piHeatingHub ]; then
		echo -e "\t\t OK"
	else
		echo -e "\t\t Skip"
	fi

	echo -n " Secure piHeatingHub "
	if [ $piHeatingHubSecure ]; then
		echo -e "\t\t OK"
	else
		echo -e "\t\t Skip"
	fi

	echo -n " Install piHeatingRemote "
	if [ $piHeatingRemote ]; then
		echo -e "\t OK"
	else
		echo -e "\t Skip"
	fi

	echo -n " Install piHeatingLCD "
	if [ $piHeatingLCD ]; then
		echo -e "\t\t OK"
	else
		echo -e "\t\t Skip"
	fi

	echo -n " Install piPowerTempLog "
	if [ $piPowerTempLog ]; then
		echo -e "\t OK"
	else
		echo -e "\t Skip"
	fi

	echo -n " Install piWeatherLog "
	if [ $piWeatherLog ]; then
		echo -e "\t\t OK"
	else
		echo -e "\t\t Skip"
	fi

	echo -n " Install handy programs "
	if [ $handy ]; then
		echo -e "\t OK"
	else
		echo -e "\t Skip"
	fi

	########## final question
	echo -e "\n Is this correct ?"
	read -p " [Y/n] " input
	case $input in
	[Nn])
		install=""
		echo "Exiting ..."
		exit
		;;
	*)
		install="y"
		break
		;;
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
	$scriptDir/scripts/packagesInstall.sh "$prerequisites" "$simulateMessage" $simulate
fi

########## install apache2
if [ $piHeatingHub ] || [ $piHeatingRemote ] || [ $piPowerTempLog ] || [ $piWeatherLog ]; then
	$scriptDir/scripts/packagesInstall.sh "apache2 apache2-utils" "$simulateMessage" $simulate
fi

########## install php
if [ $piHeatingHub ] || [ $piHeatingRemote ] || [ $piPowerTempLog ] || [ $piWeatherLog ]; then
	$scriptDir/scripts/packagesInstall.sh "php libapache2-mod-php php-common php-cli php-json php-readline" "$simulateMessage" $simulate
fi

########## install sql
if [ $piHeatingHub ] || [ $piPowerTempLog ] || [ $piWeatherLog ]; then
	$scriptDir/scripts/packagesInstall.sh "mariadb-server mariadb-client" "$simulateMessage" $simulate
fi

########## install php-mysql
if [ $piHeatingHub ]; then
	$scriptDir/scripts/packagesInstall.sh "php-mysql" "$simulateMessage" $simulate
fi

########## install py-mysql
if [ $piHeatingHub ] || [ $piPowerTempLog ] || [ $piWeatherLog ]; then
	$scriptDir/scripts/packagesInstall.sh "python-mysqldb" "$simulateMessage" $simulate
fi

########## install rrd-tool
if [ $piHeatingHub ]; then
	$scriptDir/scripts/packagesInstall.sh "rrdtool php-rrd" "$simulateMessage" $simulate
fi

########## install nmap
if [ $piHeatingHub ]; then
	$scriptDir/scripts/packagesInstall.sh "nmap" "$simulateMessage" $simulate
fi

########## install python rpi.gpio
if [ $piHeatingLCD ]; then
	echo -e "\n\n Installing Python RPi.GPIO module ... \n ----------"
	if python -c "import RPi.GPIO" >>/dev/null 2>&1; then
		echo -e "     RPi.GPIO is already installed"
	else
		if [ $simulate ]; then
			echo "$simulateMessage"
		else
			pip install rpi.gpio
		fi
	fi
fi

########## install adafruit char lcd
if [ $piHeatingLCD ]; then
	echo -e "\n\n Installing Python Adafruit_Python_CharLCD module ... \n ----------"
	if python -c "import Adafruit_CharLCD" >>/dev/null 2>&1; then
		echo -e "     Adafruit_Python_CharLCD is already installed"
	else
		if [ $simulate ]; then
			echo "$simulateMessage"
		else
			cd $scriptDir/Resources/Adafruit_Python_CharLCD
			python setup.py install
		fi
	fi
fi

########## install gpio-watch
if [ $piHeatingLCD ]; then
	echo -e "\n\n Installing gpio-watch ... \n ----------"
	if which gpio-watch >>/dev/null; then
		echo "     gpio-watch is already installed"
	else
		if [ $simulate ]; then
			echo "$simulateMessage"
		else
			cd $scriptDir/Resources/gpio-watch
			make
			make install
		fi
	fi
fi

########## install handy programs
if [ $handy ]; then
	$scriptDir/scripts/packagesInstall.sh "$handyPrograms" "$simulateMessage" $simulate
fi

########## create ~/bin
if [ $piHeatingHub ] || [ $piHeatingRemote ] || [ $piHeatingLCD ] || [ $piPowerTempLog ] || [ $piHeatingHubSecure ] || [ $piWeatherLog ]; then
	echo -e "\n\n Creating installation directory ... \n ----------"
	if [ -d "$installDir" ]; then
		echo "     Directory already exists"
	else
		if [ $simulate ]; then
			echo "$simulateMessage"
		else
			mkdir -p "$installDir"
		fi
	fi
fi

########## install piHeatingHub
if [ $piHeatingHub ]; then
	$scriptDir/scripts/piHeatingHubInstall.sh $scriptDir $installDir $DB_USERNAME $DB_PASSWORD $DB_SERVER $DB_NAME "$simulateMessage" $simulate
fi

########## make piHeating Hub secure
if [ $piHeatingHubSecure ]; then
	$scriptDir/scripts/piHeatingHubSecureInstall.sh $scriptDir $installDir
fi

########## install piHeatingRemote
if [ $piHeatingRemote ]; then
	$scriptDir/scripts/piHeatingRemoteInstall.sh $scriptDir $installDir
fi

########## install piHeatingLCD
if [ $piHeatingLCD ]; then
	$scriptDir/scripts/piHeatingLCDInstall.sh $scriptDir $installDir
fi

########## install piPowerTempLog
if [ $piPowerTempLog ]; then
	$scriptDir/scripts/piPowerTempLogInstall.sh $scriptDir $installDir
fi

########## install piWeatherLog
if [ $piWeatherLog ]; then
	$scriptDir/scripts/piWeatherLogInstall.sh $scriptDir $installDir
fi

########## configure apache
if [ $piHeatingHub ] || [ $piHeatingRemote ] || [ $piPowerTempLog ] || [ $piPowerWeatherLog ]; then
	echo -e "\n\n Reloading Apache ... \n ----------"
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		systemctl reload apache2
	fi
fi

########## restart cron
if [ $piHeatingHub ] || [ $piPowerTempLog ] || [ $piPowerWeatherLog ]; then
	echo -e "\n\n Restarting cron ... \n ----------"
	if [ $simulate ]; then
		echo "$simulateMessage"
	else
		service cron restart
	fi
fi

########## installation check
if [ $piHeatingHub ] || [ $piHeatingHubSecure ] || [ $piHeatingRemote ] || [ $piHeatingLCD ] || [ $piPowerTempLog ] || [ $piHeatingHubSecure ] || [ $piWeatherLog ]; then
	$scriptDir/scripts/postInstallCheck.sh $scriptDir
fi

########## reboot
if [ $piHeatingRemote ] || [ $piWeatherLog ]; then
	echo -e "\n\n Reboot \n ----------"
	echo -e " To finish installation you must reboot. \n\n This is due to changes in '/boot/config.txt' \n or changes in groups for user 'www-data'."

	while true; do
		echo -e "\n Reboot ?"
		read -p " [ LATER/[n]ow ] " rebootNow
		case $rebootNow in
		[Nn]) break ;;
		*)
			rebootNow=""
			break
			;;
		esac
	done

	if [ $rebootNow ]; then
		while true; do
			echo -e "\n Sure ?"
			read -p " [ Y/n ] " sure
			case $input in
			[Nn])
				echo -e "\n Remember to reboot later!"
				break
				;;
			*)
				echo -e "\n Rebooting i 5 seconds ..."
				sleep 5
				reboot
				break
				;;
			esac
		done
	fi
fi
