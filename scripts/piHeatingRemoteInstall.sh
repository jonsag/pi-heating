#!/bin/bash

########## check for arguments
if [ ! $1 ] || [ ! $2]; then
	echo -e "\n\n Error: \n This script must be run with arguments, \n or rather started from main script \n Exiting ..."
	exit 1
else
	$scriptDir=$1
	$installDir=$2
fi

########## check for root
if [[ `whoami` != "root" ]]; then
  	echo -e "\n\n Error: \n Script must be run as root."
  	exit 1
fi

########## installation
