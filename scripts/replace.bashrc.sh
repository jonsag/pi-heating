#!/bin/bash

cp /home/pi/pi-heating/scripts/bashrc /home/pi/.bashrc
cp /home/pi/pi-heating/scripts/bash_aliases /home/pi/.bash_aliases

chown pi:pi /home/pi/.bashrc
chown pi:pi /home/pi/.bash_aliases

sudo -H -u pi bash -c '. /home/pi/.bashrc'

echo "Please run '. /home/pi/.bashrc'"
