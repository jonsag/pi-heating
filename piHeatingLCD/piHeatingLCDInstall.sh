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
if [[ $OS_VERSION != *"buster"* ]]; then
  printf "\n\n EXITING : Script must be run on PI OS Buster. \n\n"
  exit 1
fi


if [ -f "/home/pi/bin/piHeatingHub/README.md" ]; then
  echo "Hub exists"
else
  printf "\n\n First you must install piHeatingHub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/piHeatingLCD/README.md" ]; then
  printf "\n\n Installing piHeatingLCD ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/piHeatingLCD" ]; then
  	printf "\n\n Deleting old install ...\n"
    rm -rf "/home/pi/piHeatingLCD"
  fi

  printf "\n\n Installing executables ...\n"
  cp -rf "/home/pi/pi-heating/piHeatingLCD/piHeatingLCD" "/home/pi/"
  
  printf "\n\n Creating gpio-watch log file ...\n"
  touch /home/pi/piHeatingLCD/gpio-watch.log
  
  printf "\n\n Setting permissions ...\n"
  chown -R pi:pi "/home/pi/piHeatingLCD"
  chmod -R 750 "/home/pi/piHeatingLCD"
  
  printf "\n\n Creating symlink for gpio service ...\n"
  ln -s /home/pi/piHeatingLCD/gpio.service /lib/systemd/system/gpio.service
  printf "\n\n Setting permissions ...\n"
  chmod 644 /home/pi/piHeatingLCD/gpio.service
  printf "\n\n Reloading service daemon ...\n"
  systemctl daemon-reload
  printf "\n\n Enabling gpio service ...\n"
  systemctl enable gpio.service
 

  if [ ! -f "/home/pi/piHeatingLCD/README.md" ]; then
      printf "\n\n EXITING : piHeatingLCD installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n piHeatingLCD is already installed. \n"
fi

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
