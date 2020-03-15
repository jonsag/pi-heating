pi-heating  

Some scripts tweaked from https://github.com/JeffreyPowell, and many others created by me.  

Also there are CAD drawings and PCB layouts to build the electrical parts.  

Eventually you will have a Raspberry Pi that:

* controls (for example) a heater
* measures and logs your electric power consumption
* measures and logs numerous temperatures
* measures and logs wind direction and speed
* measures and logs rain
* presents it all via a web GUI with some nice graphs
* also presents it on LCD displays
* can export logs to (spreadsheet or) csv

Let's start it all by

Installing OS
=============================
Download Raspbian Buster Lite from https://www.raspberrypi.org/downloads/raspbian/  
Choose the Light zip-file  

Cd to where your download is  
>$ unzip 2020-02-13-raspbian-buster-lite.zip  

Insert SD-card and find out drive letter  
>$ dmesg  

For example /dev/mmcblk0 or /dev/sdb  

Unmount if mounted  
>$ umount /dev/mmcblk0p1  

Write image to SD-card  
>$ sudo dd bs=4M if=2020-02-13-raspbian-buster-lite.img of=/dev/mmcblk0 conv=fsync status=progress  

Remove SD-card and insert it again to make new partitons visible     

Mount the first partition  
>$ sudo mount /dev/mmcblk0p1 /mnt/tmp  

Write empty file to boot partition to enable ssh at boot  
>$ sudo touch /mnt/tmp/ssh  

Remove SD-card and insert it a Rpi connected to your local network and boot it up  

Rpi configuration
-----------------------------
Connect to Rpi via ssh  
Login with user: pi and password:raspberry  

Update  
>$ sudo apt-get update && sudo apt-get upgrade  

Configure  
>$ sudo raspi-config   

1		Change password  
2 N1	Change hostname  
4 T1	Set locales  
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
Install prerequisites
>$ sudo apt install git python-dev python-setuptools build-essential python-smbus python-pip rsync ttf-mscorefonts-installer   

Also install some other programs that will come in handy later on  
>$ sudo apt install emacs screen locate  

Go to your home directory, that we from now on will assume is  

	/home/pi
	
>$ cd  

Download source files  
>$ git clone https://github.com/jonsag/pi-heating.git  

Install piHeating
==========
Go to directory pi-heating/piHeating  
>$ cd ~/pi-heating/piHeating  

and follow  

	README - piHeating.md
	
You will have to decide if you want to run hub and remote on same Pi, or hub and remote on separate devices.  

Install piHeatingLCD
==========
If you want to use an LCD on the hub  
>$ cd ~/pi-heating/piHeatingLCD  

and follow  

	README - piHeatingLCD.md
	
Install piPowerTempLog
==========
For more extensive temperature logging, and also power logging  
>$ cd ~/pi-heating/piPowerTempLog  

and follow  

	README - piPowerTempLog.md
	
Install piWeatherLog
==========
Under construction ...  

	
Quick reference
==========
What is installed and where
----------
Executables installed in  

	/home/pi
	
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

* executables installs in ~/piHeatingHub  
* www installs in /var/www/piHeatingHub  
* runs on port 8080  
* mysql setup creates password, and stores credentials /home/pi/piHeatingHub/config/config.ini  
* secure install creates password for user 'admin', and stores it in /home/pi/piHeatingHub/.htpasswd  
* runs cron job at /home/pi/piHeatingHub/cron/piHeatingHubWrapper.sh every minute  

piHeatingRemote  

* executables installs in ~/piHeatingRemote  
* www installs in /var/www/piHeatingRemote  
* runs on port 8081

piHeatingLCD  

* executables installs in ~/piHeatingLCD  
* requires gpio-watch  
* requires Adafruit Char LCD

piPowerTempLog  

* executables installs in ~/piPowerTempLog  
* www installs in /var/www/piPowerTempLog  
* runs on port 8082
* runs cron job at /home/pi/piPowerTempLog/cron/wrapper.sh every 2 minutes  

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

On hub
----------
View gpio.service  
>$ cat /lib/systemd/system/gpio.service  

View gpio script  
>$ cat /home/pi/piHeatingLCD/gpio-scripts  

View gpio-watch log  
>$ tail -f ~/piHeatingLCD/gpio-watch.log  

Test LCD  
>$ $HOME/piHeatingLCD/print-to-lcd.py -1 test1 -2 test2  

Simulate Button 1 press  


View config file  
>$ cat $HOME/piHeatingHub/config/config.ini  

Login to database  
>$ mysql -u pi -p<password> piHeatingDB (using password from the above config)  

Change ip on sensor  
>$ UPDATE sensors SET ip = 'new ip' WHERE ip = 'old ip';  

On remote
----------
Show sensor ids  
>$ ls /sys/bus/w1/devices/  













