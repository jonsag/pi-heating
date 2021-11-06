#!/bin/bash

ARG1=$1
ARG2=$2
ARG3=$3
ARG4=$4

########## check for arguments
if [ ! $ARG1 ] || [ ! $ARG2] || [ ! $ARG3]; then
    echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
    exit 1
else
    scriptDir=$ARG1
    installDir=$ARG2
    simulateMessage=$ARG3
    simulate=$ARG4
fi

########## check for root
if [[ `whoami` != "root" ]]; then
    echo -e "\n\n Error: \n Script must be run as root  \n Exiting ..."
    exit 1
fi