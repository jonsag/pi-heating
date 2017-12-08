# pi-heating
Some scripts tweaked from https://github.com/JeffreyPowell


Installation
-----------------------------
$ wget "https://github.com/jonsag/pi-heating/archive/0.2.tar.gz" -O "/home/pi/pi-heating.tar.gz"
$ cd /home/pi
$ tar -xvzf pi-heating.tar.gz
or
$ cd /home/pi
$ git clone https://github.com/jonsag/pi-heating.git


On pi running as hub or hub/remote:
$ sudo pi-heating/pi-heating-hub-install.sh
$ sudo pi-heating/pi-heating-hub-mysql-install.s
$ sudo pi-heating/pi-heating-remote-install.sh
$ sudo pi-heating/pi-heating-hub-secure.sh


If hub also will have extended weather and power logging:
$ sudo pi-heating/pi-heating-weather-install.sh
		wget "http://www.triconsole.com/php/calendar_download.php" -O "/home/pi/calendar.zip"


On pi running solely as remote:
$ sudo pi-heating/pi-heating-remote-install.sh


