piPowerTempLog  

A sub project to monitor power and temperatures  


Installing OS
=============================
Download Raspbian Stretch Lite from https://www.raspberrypi.org/downloads/raspbian/  
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


Install LAMP
==========
Install packages  
>$ sudo apt install apache2 apache2-utils mariadb-server mariadb-client php php-mysql libapache2-mod-php php-common php-cli php-json php-readline

Check apache is running  
>$ systemctl status apache2

If not:
>$ sudo systemctl start apache2

>$ sudo systemctl enable apache2

Check MariaDB is running  
>$ systemctl status mariadb

If not:
>$ sudo systemctl start mariadb

>$ sudo systemctl enable mariadb

Run MariaDB post install script  
>$ sudo mysql_secure_installation

Set MariaDB root password  
Press 'enter'  to all remaining questions  

Test to connect to the db  
>$ sudo mysql -u root  

Enable the apache php mod  
>$ sudo a2enmod php7.3

Restart apache  
>$ sudo systemctl restart apache2

Test apache-php
----------
Create info.php in web root  
>$ sudo emacs /var/www/html/info.php

Put following in the file  

	<?php phpinfo(); ?>
	
Go to

	http://<raspberry pi's ip>/info.php
	
in a browser
	
Installation
==========
Install requisites
----------
>$ sudo apt install git rsync ttf-mscorefonts-installer

Other useful tools
----------
>$ sudo apt install emacs screen

Get source files
----------
>$ cd /home/pi  

>$ git clone https://github.com/jonsag/pi-heating.git  

>$ cd /home/pi/pi-heating/piPowerTempLog  

Setup database and user  
>$ sudo mysql -u root < database-setup.sql

Add tables to the new database  
>$ mysql -u arduino -parduinopass powerTempLog < tables-setup.sql

Copy contents of arduinolog to webroot  
>$ sudo cp -r piPowerTempLog /var/www/html/

Download calendar_localized and unzip it ( http://www.triconsole.com/php/calendar_datepicker.php)  
>$ sudo unzip calendar_localized* -d /var/www/html/piPowerTempLog/

Add symbolic links for fonts  
>$ cd /usr/share/fonts/truetype

>$ sudo ln -s msttcorefonts/arialbd.ttf arialbd.ttf

>$ sudo ln -s msttcorefonts/arial.ttf arial.ttf

Change ownership  
>$ sudo chown www-data:www-data -R /var/www/html

Add a line to your crontab  
>$ crontab -e

Add the following:  

	*/2 * * * * /usr/bin/php /var/www/html/piPowerTempLog/powerPoller.php 0 1 cron > /dev/null 2>&1
	*/2 * * * * /usr/bin/php /var/www/html/piPowerTempLog/tempPoller.php 0 1 cron > /dev/null 2>&1

Host settings
----------
Make sure your /etc/hosts has an entry for the arduino, for example:  

	192.168.10.10   arduino01
