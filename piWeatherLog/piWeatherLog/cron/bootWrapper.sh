#!/bin/bash

# set up tty
stty -F /dev/ttyACM0 cs8 9600 ignbrk -brkint -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts

# start screen session detached
screen -d -m -S init /dev/ttyACM0 9600

# wait
sleep 5

# kill screen
screen -XS init quit
