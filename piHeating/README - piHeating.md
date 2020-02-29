piHeating  

Some scripts tweaked from https://github.com/JeffreyPowell  

On pi running as hub or hub/remote:
-----------------------------
>$ sudo ./piHeatingHubInstall.sh  

Run MariaDB post install script  
Set MariaDB root password  
Press 'enter'  to all remaining questions  
>$ sudo mysql_secure_installation  

Create database  
>$ sudo ./piHeatingHubMysqlSetup.sh  

Secure web server  
>$ sudo ./piHeatingHubSecure.sh  


On pi running solely as remote or as hub/remote:
-----------------------------
>$ sudo ./piHeatingRemoteInstall.sh  

After connecting Dallas temperature sensors,  
find 1-wire devices serial numbers  
>$ ls /sys/bus/w1/devices/  

Edit /home/pi/piHeatingRemote/configs/sensors and insert serials and names, for example  
28-0516b4ff09ff = Out  

To see value  
>$ cat /sys/bus/w1/devices/28-0416c1ec26ff/w1_slave  

See how many devices added  
>$ curl localhost:8081/count.php && echo  

See names  
>$ curl localhost:8081/name.php?id=1 && echo  

change id=1 to id=2 etc  

See values  
>$ curl localhost:8081/value.php?id=1 && echo  


If using LCD:
=============================
The LCD and buttons will work if:  

* you have a schedule that always keep a low temperature  
* you have a single mode that pulls up the temperature  
* you have a single timer that pulls up the temperature  

>$ sudo ./piHeatingLCDInstall.sh  

>$ sudo easy_install -U distribute  

>$ sudo pip install rpi.gpio  

Install Adafruit_Python_CharLCD python module by Adafruit from https://github.com/adafruit/Adafruit_Python_CharLCD.git  
>$ cd ~/pi-heating/Resources/Adafruit_Python_CharLCD  

>$ sudo python setup.py install  

Install gpio-watch by larsks from https://github.com/larsks/gpio-watch  
>$ cd ~/pi-heating/Resources/gpio-watch  

>$ make  

>$ sudo make install  


Electrical
==========
Hook up relay to hub:
-----------------------------
GPIO +5V to relay +  
GPIO GND to relay GND  
Pin 10 - GPIO15 to heating relay signal  

Hook up 1-wire temp sensors to remote:
-----------------------------
GPIO 3,3V to 1-wire power  
GPIO GND to 1-wire GND  
Pin 8 - GPIO14(4) to 1-wire signal  
Connect 4,7k resistor between power and signal  

Hook up LCD and buttons to hub:
-----------------------------
GPIO GND 	LCD pin 1 GND  
GPIO +5V 	LCD pin 2 VCC  
			        LCD pin 3 CONTR - brightness control  
Pin 23 - GPIO11  	LCD pin 4 RS  
             GND  		LCD pin 5 R/W  
Pin 21 - GPIO9  	LCD pin 6 E  
Pin 19 - GPIO10  	LCD pin 11 D4  
Pin 15 - GPIO22  	LCD pin 12 D5  
Pin 13 - GPIO27  	LCD pin 13 D6  
Pin 11 - GPIO17  	LCD pin 14 D7  
GPIO +3,3V LCD pin 15 N_C1 - backlight  
Pin 7 - GPIO4	LCD pin 16 N_C2 - backlight on/off  

Buttons
Pin 12 - GPIO18	button 1  
Pin 16 - GPIO23	button 2  
Pin 18 - GPIO24	button 3  
Pin 22 - GPIO25	button 4  

Quick reference
==========
Notes
----------
piHeatingHub  

* executables installs in ~/piHeatingHub  
* www installs in /var/www/html/piHeatingHub  
* runs on port 8080  
* mysql setup creates password, and stores credentials /home/pi/piHeatingHub/config/config.ini  
* secure install creates password for user 'admin', and stores it in /home/pi/piHeatingHub/.htpasswd  

piHeatingRemote  

* executables installs in ~/piHeatingRemote  
* www installs in /var/www/html/piHeatingRemote  
* runs on port 8081

URLs:
----------
Hub:
Pi heating hub status page: <IP\>:8080/status.php  

Remote:  
Sensors count: IP:8081/count.php  
Sensor name for sensor #1: <IP\>:8081/name.php?id=1  
Sensor value for sensor #1: <IP\>:8081/value.php?id=1


Testing  
=============================
Below is only for my testing  
Use with caution!  

On hub:  
Test LCD
>$ $HOME/piHeatingLCD/print-to-lcd.py -1 test1 -2 test2  

View config file  
>$ cat $HOME/piHeatingHub/config/config.ini  

Login to database  
>$ mysql -u pi -ppassword pi_heating_db (using password from the above config)  

Change ip on sensor  
>$ UPDATE sensors SET ip = 'new ip' WHERE ip = 'old ip';  

On remote:  
Show sensor ids  
>$ ls /sys/bus/w1/devices/  















