# pi-heating
Some scripts tweaked from https://github.com/JeffreyPowell


Installation
=============================

$ wget "https://github.com/jonsag/pi-heating/archive/0.2.tar.gz" -O "/home/pi/pi-heating.tar.gz"
$ cd /home/pi
$ tar -xvzf pi-heating.tar.gz
or
$ cd /home/pi
$ git clone https://github.com/jonsag/pi-heating.git


On pi running as hub or hub/remote:
-----------------------------
$ sudo pi-heating/pi-heating-hub-install.sh
$ sudo pi-heating/pi-heating-hub-mysql-install.sh
$ sudo pi-heating/pi-heating-hub-secure.sh


If hub also will have extended weather and power logging:
-----------------------------
$ sudo pi-heating/pi-heating-extende-log-install.sh
		$ wget "http://www.triconsole.com/php/calendar_download.php" -O "/home/pi/calendar.zip"


On pi running solely as remote or as hub/remote:
-----------------------------
$ sudo pi-heating/pi-heating-remote-install.sh









On pi running as weather logger:
-----------------------------

Find out tty-device
$ dmesg | grep tty



Installing and running Arduino IDE:
=============================

Download Arduino IDE from https://www.arduino.cc/en/Main/Software
$ mv arduino-*.tar.xz ~/bin
$ cd ~/bin
$ tar -xvJf arduino-*.tar.xz
$ cd arduino-*
$ ./install.sh

Install Average library:
-----------------------------
Copy directory Average to your Arduino/libraries directory

Start Arduini IDE

Check settings and install sketch:
-----------------------------
Select Board and Port
Open sketch
Compile and upload to arduino

$ stty -F /dev/ttyUSB0 cs8 9600 ignbrk -brkint -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts
$ stty -F /dev/ttyS0 ispeed 9600 ospeed 9600 -ignpar cs8 -cstopb -echo

Connect to arduino with screen:
$ screen /dev/ttyACM1 9600 -S <session name>
To get screen command promp, enter
[C-a] :
Then type
quit
and [Return]
	or from outside of screen
$ screen -X -S <session name> quit

Kill screen with ^ak or control-a k

$ rsync -rci ~/Documents/EclipseWorkspace/pi-heating/pi-heating-hub-extended-log/www/* pi@raspberry03:/var/www/pi-heating-hub-extended-log/










