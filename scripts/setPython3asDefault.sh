#!/bin/bash

ARG1=$1
ARG2=$2

########## check for arguments
if [[ ! $ARG1 ]]; then
    echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
    exit 1
else
    simulateMessage=$ARG1
    simulate=$ARG2
fi

########## check for root
if [[ $(whoami) != "root" ]]; then
    echo -e "\n\n Error:\n Script must be run as root."
    if [ $simulate ]; then
        echo "$simulateMessage"
    else
        exit 1
    fi
fi

echo " Current python version: "
python -V

echo " Setting up new  link..."
if [ $simulate ]; then
    echo "$simulateMessage"
else
    rm /usr/bin/python
    ln -s /usr/bin/python3 /usr/bin/python
fi

echo " New python version: "
python -V
