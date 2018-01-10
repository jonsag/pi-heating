#!/bin/bash

#          Raspberry Pi setup, 'pi-heating-LCD' configuration script.

# Die on any errors

#set -e
clear


if [[ `whoami` != "root" ]]
then
  printf "\n\n Script must be run as root. \n\n"
  exit 1
fi


OS_VERSION=$(cat /etc/os-release | grep VERSION=)
if [[ $OS_VERSION != *"stretch"* ]]
then
  printf "\n\n EXITING : Script must be run on PI OS Stretch. \n\n"
  exit 1
fi


if [ -f "/home/pi/pi-heating-hub/README.md" ]
then
  echo "Hub exists"
else
  printf "\n\n First you must install pi-heating-hub. \n\n"
  exit 1
fi


if [ ! -f "/home/pi/pi-heating-LCD/README.md" ]
then
  printf "\n\n Installing pi-heating-LCD ...\n"

  cd /home/pi
  
  if [ -d "/home/pi/pi-heating-LCD" ]
  then
    rm -rf "/home/pi/pi-heating-LCD"
  fi

  mv "/home/pi/pi-heating/pi-heating-LCD" "/home/pi/pi-heating-LCD"
  
  chown -R pi:pi "/home/pi/pi-heating-LCD"
  chmod -R 750 "/home/pi/pi-heating-LCD"

  if [ ! -f "/home/pi/pi-heating-LCD/README.md" ]
    then
      printf "\n\n EXITING : pi-heating-LCD installation FAILED\n"
      exit 1
    fi

else
  printf "\n\n pi-heating-LCD is already installed. \n"
fi

printf "\n\n Installation Complete. Some changes might require a reboot. \n\n"
exit 1
