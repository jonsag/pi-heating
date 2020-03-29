pi-heating  

Some scripts tweaked from https://github.com/JeffreyPowell, and many others created by me.  

Also there are CAD drawings and PCB layouts to build the electrical parts.  

Eventually you will have a Raspberry Pi that:

* controls (for example) a heater
* measures and logs your electric power consumption
* measures and logs numerous temperatures
* measures and logs wind direction and speed
* measures and logs rain
* presents it all via web GUI with some nice graphs
* also presents it on LCD displays
* can export logs to (spreadsheet or) csv

Let's start it all by

Installing OS
=============================
Download Raspbian Buster Lite from https://www.raspberrypi.org/downloads/raspbian/  
Choose the Light zip-file  

Cd to where your download is  
>$ unzip *-raspbian-buster-lite.zip  

Insert SD-card and find out drive letter  
>$ dmesg  

For example /dev/mmcblk0 or /dev/sdb  

Unmount if mounted  
>$ umount /dev/mmcblk0p1  

Write image to SD-card  
>$ sudo dd bs=4M if=<version\>-raspbian-buster-lite.img of=/dev/<device\> conv=fsync status=progress  

Remove SD-card and insert it again to make new partitons visible     

Mount the first partition  
>$ sudo mount /dev/<device\>1 /mnt/tmp  

Write empty file to boot partition to enable ssh at boot  
>$ sudo touch /mnt/tmp/ssh  

Remove SD-card and insert it in a RPi connected to your local network and boot it up  

RPi configuration
==========
How to find RPi's IP
----------
If you can't locate the IP, here's a little tutorial  

First find your subnet  
>$ ip -o -f inet addr show | awk '/scope global/ {print $4}'  

You will get something like  

	192.168.10.39/24   

where the first ofcourse is your ip, end the second is the netmask  

Now scan your local network for hosts  
>$ nmap -snP 192.168.10.0/24  

where the first is your subnet, and the last is the netmask  
Try to figure out which is your RPi from the output  

How to connect without ssh password (optional)
----------
If you haven't already, create a keypair  
>$ ssh-keygen ~/.ssh/id_rsa  

Copy the public key to RPi  
>$ ssh-copy-id -i ~/.ssh/id_rsa.pub pi@<IP\>  

Connect and configure
----------
>$ ssh <IP\> -l pi  

Login with user: pi and password:raspberry  

Update  
>$ sudo apt-get update && sudo apt-get upgrade  

Configure  
>$ sudo raspi-config   

1		Change password  
2 N1	Change hostname  
4 T1	Set locales (I choose en_GB.UTF-8 and sv_SE.UTF-8, setting en_GB.UTF-8 as default)  
4 T2	Set time zone  
4 T3	Choose keyboard layout    
4 T4	Set wifi country  
5 P7	Enable 1-wire at boot  
7 A1	Expand file system to use whole SD-card  
7 A3	Set memory split to 16  

Reboot to set new options  

Now it's time to:

Download sources
==========
Install git, if you haven't already  
>$ sudo apt install git   

Download source files  
>$ git clone https://github.com/jonsag/pi-heating.git  

Installation
==========
Go to the newly downloaded directory 
>$ cd pi-heating

and run the install script  

>$ sudo ./install.sh
	
The script will ask you many questions, and you will have some options on each:  

* Click enter to accept the default 'yes'  
* Enter 'n' or 'N' to decline  
* Enter 'h' or 'H' to view the help explanation  

Also you will have to answer some questions during the installs themselves, especially when MariaDB is installed.  

The electrical builds
=========
For all electrical builds there are CAD files for each project under 'Documentation'.  
Not all have finished PCB etch masks available as pdf.  
If you like to make some yourself, install KiCad (https://www.kicad-pcb.org) and just make them.  
I have made all as single layer PCBs myself, but just go ahead and route some double layered ones.   
If you don't want to make them them yourself, I can recommend JLCPCB (https://jlcpcb.com), reasonably fast and very cheap.  

piHeatingLCD
----------
![ ](Documents/images/piHeatingLCD-pcb_top.JPG  "piHeatingLCD PCB top view")

ardPowerTempLog
----------
![testing](Documents/images/ardWeatherLog-pcb_bottom.JPG  "ardPowerTempLog PCB bottom view")  

This build also require some current clamps.  
![ ](Documents/images/ardPowerTempLog-current_clamp.JPG  "ardPowerTempLog current clamp")  
I use three of these. If you go with other ones you will have to adapt your resistor values accordingly.  

Also of course you will need some DS18B20 1-wire temperature sensors.   
![ ](Documents/images/ardPowerTempLog-dallas.JPG  "ard>PowerTempLog temp sensor")  
Other ones will also do, but then check what library and settings you use in the Arduino sketch.  
I have soldered cables directly to the pins, and connected it to a phono plug.  

Then you will need some device to catch the blinks on your power meter.  
![ ](Documents/images/ardPowerTempLog-led_watch.JPG  "ardPowerLog LED watch")  

ardWeatherLog
----------
![ ](Documents/images/ardWeatherLog-full.JPG  "ardWeatherLog full")  
I use an ordinary ethernet cable to connect the Arduino to the weather sensors.  

The sensors are some devices I got from a cheap weather station.  
![ ](Documents/images/ardWeatherLog-sensors.JPG  "ardWeatherLog sensors")  
I just tossed the LCD that went with it.  

Quick reference
==========
What is installed and where
----------
Executables installed in  

	/home/pi/bin
	
Web GUI installed in  

	/var/www
	
Apache site configurations in  

	/etc/apache2/sites-enabled/
	
Apache listen directives in  

	/etc/apache2/ports.conf
	
Gpio service installed at  

	/lib/systemd/system/gpio.service

Extended boot parameters in  

	/boot/config.txt
	
Database at  

	/var/lib/mysql/piHeatingDB
	
Cron jobs in  

	/etc/cron.d/piHeating
	/etc/cron.d/piPowerTempLog

Notes
----------
piHeatingHub  

* executables installs in /home/pi/bin/piHeatingHub  
* www installs in /var/www/piHeatingHub  
* runs on port 8080  
* mysql setup creates password, and stores credentials /home/pi/bin/piHeatingHub/config/config.ini  
* secure install creates password for user 'admin', and stores it in /home/pi/bin/piHeatingHub/.htpasswd  
* runs cron job at /home/pi/bin/piHeatingHub/cron/piHeatingHubWrapper.sh every minute  

piHeatingRemote  

* executables installs in /home/pi/bin/piHeatingRemote  
* www installs in /var/www/piHeatingRemote  
* runs on port 8081

piHeatingLCD  

* executables installs in /home/pi/bin/piHeatingLCD  
* requires gpio-watch  
* requires Adafruit Char LCD

piPowerTempLog  

* executables installs in /home/pi/bin/piPowerTempLog  
* www installs in /var/www/piPowerTempLog  
* runs on port 8082
* runs cron job at /home/pi/bin/piPowerTempLog/cron/wrapper.sh every 2 minutes  

URLs:
----------
Hub:  
Pi heating hub status page: http://\<IP\>:8080/status.php  

Remote:  
Sensors count: IP:8081/count.php  
Sensor name for sensor #1: http://\<IP\>:8081/name.php?id=1  
Sensor value for sensor #1: http://\<IP\>:8081/value.php?id=1

Power log:  
Main page: http://\<IP\>:8082  


Testing  
==========
Below is only for my testing during development  
Use with caution!  

Install and run Arduino IDE:
----------
Install Arduino IDE from https://www.arduino.cc/en/Main/Software  
>$ mv arduino-*.tar.xz ~/bin  
>$ cd ~/bin  
>$ tar -xvJf arduino-*.tar.xz  
>$ cd arduino-*  
>$ ./install.sh  

Install Average library:
----------
Copy directory Average to your Arduino/libraries directory  

Set up passwordless ssh login
----------
>$ ssh-keygen  

>$ ssh-copy-id  -i ~/.ssh/id_rsa.pub pi@192.168.10.52  

Upload source  
>$ rsync -avz --delete . pi@192.168.10.52:pi-heating/  

Upload piPowerTempLog www  
>$ rsync -avz . pi@192.168.10.52:/var/www/piPowerTempLog && ssh pi@192.168.10.52 "sudo chown pi:www-data /var/www/piPowerTempLog -R && sudo chmod 755 /var/www/piPowerTempLog/*.php"  

Upload piHeatingHub www  
>$ rsync -avz . pi@192.168.10.52:/var/www/piHeatingHub && ssh pi@192.168.10.52 "sudo chown pi:www-data /var/www/piHeatingHub -R && sudo chmod 755 /var/www/piHeatingHub/*.php"  

On hub
----------
View gpio.service  
>$ cat /lib/systemd/system/gpio.service  

View gpio script  
>$ cat /home/pi/bin/piHeatingLCD/gpio-scripts  

View gpio-watch log  
>$ tail -f ~/bin/piHeatingLCD/gpio-watch.log  

Test LCD  
>$ /home/pi/bin/piHeatingLCD/print-to-lcd.py -1 test1 -2 test2  

Simulate Button 1 press  


View config file  
>$ cat /home/pi/bin/piHeatingHub/config/config.ini  

Login to database  
>$ mysql -u pi -p$(cat /home/pi/bin/piHeatingHub/config/config.ini | grep password | awk '{ print $3 }') piHeatingDB  

using password from the above config  

Change ip on sensor  
>$ UPDATE sensors SET ip = 'new ip' WHERE ip = 'old ip';  

Set values for tty communications  
>$ stty -F /dev/ttyACM0 ispeed 9600 ospeed 9600 -ignpar cs8 -cstopb -echo  

On remote
----------
Show sensor ids  
>$ ls /sys/bus/w1/devices/  













