pi-heating  

Some scripts tweaked from https://github.com/JeffreyPowell  

Installing OS
=============================
Download Raspbian Stretch Lite from https://www.raspberrypi.org/downloads/raspbian/  
Choose the Light zip-file  

Cd to where your download is  
$ unzip 2017-11-29-raspbian-stretch-lite.zip  

Insert SD-card and find out drive letter  
$ dmesg  
For example /dev/mmcblk0 or /dev/sdb  

Unmount if mounted  
$ umount /dev/mmcblk0p1  

Write image to SD-card  
$ dd bs=4M if=2017-11-29-raspbian-stretch-lite.img of=/dev/mmcblk0 conv=fsync status=progress 

Remove SD-card and insert it again to make new partitons visible     

Mount the first partition  
$ sudo mount /dev//dev/mmcblk0p1 /mnt/tmp  

Write empty file to boot partition to enable ssh at boot  
$ sudo touch /mnt/tmp/ssh  

Remove SD-card and insert it a Rpi connected to your local network and boot it up 

Rpi configuration
-----------------------------
Connect to Rpi via ssh  
Login with user: pi and password:raspberry 

Update  
$ sudo apt-get update && sudo apt-get upgrade  

Configure  
$ sudo raspi-config   
1		Change password  
2 N1	Change hostname  
3 T1	Set locales  
3 T2	Set time zone  
3 T3	Choose keyboard layout    
3 T4	Set wifi country  
5 P7	Enable 1-wire at boot  
7 A1	Expand file system to use whole SD-card  
7 A3	Set memory split to 16  
Reboot to set new options  

Install requisites
-----------------------------
$ sudo apt-get install git  


Installation
=============================
$ cd /home/pi  
$ git clone https://github.com/jonsag/pi-heating.git  

$ cd /home/pi/pi-heating

On pi running as hub or hub/remote:
-----------------------------
$ sudo ./pi-heating-hub-install.sh  

Initialize mysql  
$ sudo mysql -u root -p  
Use the same password as pi login  
Quit with exit  

$ sudo ./pi-heating-hub-mysql-setup.sh  
$ sudo ./pi-heating-hub-secure.sh  

Hook up relay to hub:
-----------------------------
Pin 2 - GPIO +5V to relay +  
Pin 14 - GPIO GND to relay GND  
Pin 10 - GPIO 15 to heating relay signal  

If hub also will have extended weather and power logging:
-----------------------------
$ sudo ./pi-heating-extended-log-install.sh  
		$ wget "http://www.triconsole.com/php/calendar_download.php" -O "/home/pi/calendar.zip"  

Build arduino-power-logger  
Edit sketch passive_logger_no_time_static_ip.ino  
Change lines 41-43  
	byte mac[] = {  
	  0x90, 0xA2, 0xDA, 0x0C, 0x00, 0x76 }; // MAC address, printed on a sticker on the shield
	IPAddress ip(192,168,10,10); // ethernet shields wanted IP  
to your boards MAC and desired IP  

Start up your arduino hooked up to your LAN  

Edit /var/www/pi-heating-extended-log/config.php  
Change lines 24-25  
	$powerUrl = 'http://192.168.10.10';  
	$powerPollReset = 'http://192.168.10.10/?pollReset';  
to same IP as above  


On pi running solely as remote or as hub/remote:
-----------------------------
$ sudo ./pi-heating-remote-install.sh  

Hook up 1-wire temp sensors to remote:
-----------------------------
Pin 1 - GPIO 3,3V to 1-wire power  
Pin 6 - GPIO GND to 1-wire GND  
Pin 7 - GPIO 4 to 1-wire signal  
Connect 4,7k resistor between power and signal  

Find 1-wire devices serial numbers  
$ ls /sys/bus/w1/devices/  

Edit /home/pi/pi-heating-remote/configs/sensors and insert serials and names, for example  
28-0516b4ff09ff = Out  

To see value  
$ cat /sys/bus/w1/devices/28-0416c1ec26ff/w1_slave  

See how many devices added  
$ curl localhost:8081/count.php && echo  

See names  
$ curl localhost:8081/name.php?id=1 && echo  
change id=1 to id=2 etc  

See values  
$ curl localhost:8081/value.php?id=1 && echo  

On pi running as weather logger:
-----------------------------
$ sudo ./pi-heating-weather-install.sh  

Add apache user to dialout and tty group  
$ sudo usermod -a -G dialout, tty www-data  

Reboot pi  

Find out tty-device  
$ dmesg | grep tty  
Probably named someting like '/dev/ttyACM0'  
Edit /var/www.pi-heating-weather/weather.php  
Change line 32  
	define("PORT","/dev/ttyACM0");  
so it matches the output from above  

If using LCD:
=============================
The LCD and buttons will work if:  
* you have a schedule that always keep a low temperature  
* you have a single mode that pulls up the temperature  
* you have a single timer that pulls up the temperature  

$ sudo ./pi-heating-LCD-install.sh  

$ sudo apt-get install python-dev python-setuptools build-essential python-smbus  
$ sudo easy_install -U distribute  
$ sudo apt-get install python-pip  
$ sudo pip install rpi.gpio  

Install Adafruit_Python_CharLCD python module by Adafruit from https://github.com/adafruit/Adafruit_Python_CharLCD.git  
$ cd /home/pi/pi-heating/Adafruit_Python_CharLCD  
$ sudo python setup.py install  

Install gpio-watch by larsks from https://github.com/larsks/gpio-watch
$ cd /home/pi/pi-heating/gpio-watch  
$ make  
$ sudo make install

Hook up LCD and buttons:
-----------------------------
Pin 34 - GPIO GND 	LCD pin 1 GND  
Pin  2 - GPIO +5V 	LCD pin 2 VCC  
					LCD pin 3 CONTR - brightness control  
Pin 38 - GPIO 20  	LCD pin 4 RS  
             GND  	LCD pin 5 R/W  
Pin 40 - GPIO 21  	LCD pin 6 E  
Pin 31 - GPIO  6  	LCD pin 11 D4  
Pin 33 - GPIO 13  	LCD pin 12 D5  
Pin 35 - GPIO 19  	LCD pin 13 D6  
Pin 37 - GPIO 26  	LCD pin 14 D7  
Pin 17 - GPIO +3,3V LCD pin 15 N_C1 - backlight  
Pin 29 - GPIO 5		LCD pin 16 N_C2 - backlight on/off  

Pin 23 - button 1

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

$ stty -F /dev/ttyACM0 ispeed 9600 ospeed 9600 -ignpar cs8 -cstopb -echo  

Connect to arduino with screen:  
$ screen /dev/ttyACM0 9600 -S <session name>  
To get screen command promp, enter  
[C-a] :  
Then type  
quit  
and [Return]  
	or from outside of screen  
$ screen -X -S <session name> quit  

Kill screen with ^ak or control-a k  

$ rsync -rci ~/Documents/EclipseWorkspace/pi-heating/pi-heating-hub-extended-log/www/* pi@raspberry03:/var/www/pi-heating-hub-extended-log/
$ rsync -rci ~/Documents/EclipseWorkspace/pi-heating/pi-heating-hub/www/* pi@raspberry03:/var/www/pi-heating-hub/

$ rsync -raci ~/Documents/EclipseWorkspace/pi-heating/pi-heating-LCD/* pi@raspberry05:/home/pi/pi-heating-LCD/








