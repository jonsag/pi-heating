#!/bin/bash

ARG1=$1
ARG2=$2
ARG3=$3

########## check for arguments
if [[ ! $ARG1 ]] || [[ ! $ARG2 ]]; then
    echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
    exit 1
else
    scriptDir=$ARG1
    simulateMessage=$ARG2
    simulate=$ARG3
fi

########## check for root
if [[ `whoami` != "root" ]]; then
    echo -e "\n\n Error: \n Script must be run as root  \n Exiting ..."
    exit 1
fi

echo -e "\n\n Replacing .bashrc ... \n ----------"
if [ $simulate ]; then
    echo "$simulateMessage"
else
    echo " Copying files ..."
    cp $scriptDir/scripts/bashrc /home/pi/.bashrc
    cp $scriptDir/scripts/bash_aliases /home/pi/.bash_aliases
    
    echo " Setting ownership ..."
    chown pi:pi /home/pi/.bashrc
    chown pi:pi /home/pi/.bash_aliases
    
    echo " Sourcing file ..."
    sudo -H -u pi bash -c '. /home/pi/.bashrc'
    
    echo "     Please run '. /home/pi/.bashrc'"
fi


