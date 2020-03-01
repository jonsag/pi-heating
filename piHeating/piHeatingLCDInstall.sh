#!/bin/bash

#          Raspberry Pi setup, 'piHeatingLCD' configuration script.

# Die on any errors

#set -e
clear


if [[ `whoami` != "root" ]]
then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi


OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"buster"* ]]
then
  printf "\n\n EXITING : Script must be run on PI OS Buster. \n\n"
  exit 1
fi


if [ -f "/home/pi/piHeatingHub/README.md" ]
then
  echo "Hub exists"
else
  printf "\n\n First you must install piHeatingHub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/piHeatingLCD/README.md" ]
then
  printf "\n\n Installing piHeatingLCD ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/piHeatingLCD" ]
  then
    rm -rf "/home/pi/piHeatingLCD"
  fi

  cp -rf "/home/pi/pi-heating/piHeating/piHeatingLCD" "/home/pi/piHeatingLCD"
  
  touch /home/pi/piHeatingLCD/gpio-watch.log
  
  chown -R pi:pi "/home/pi/piHeatingLCD"
  chmod -R 750 "/home/pi/piHeatingLCD"
  
  ln -s /home/pi/piHeatingLCD/gpio.service /lib/systemd/system/gpio.service
  chmod 644 /lib/systemd/system/gpio.service
  systemctl daemon-reload
  systemctl enable gpio.service
 

  if [ ! -f "/home/pi/piHeatingLCD/README.md" ]
    then
      printf "\n\n EXITING : piHeatingLCD installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n piHeatingLCD is already installed. \n"
fi

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
