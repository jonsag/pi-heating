piPowerTempLog  

A sub project to monitor power and temperatures  





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
>$ sudo unzip ../Resources/calendar_localized* -d /var/www/html/piPowerTempLog/

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
	
Arduino setup
==========
Open ardCurrentTempLog  

Edit sketch ardCurrentTempLog/configuration.h  
Change lines:  

	byte mac[] = {
	0x90, 0xA2, 0xDA, 0x0C, 0x00, 0x76
	}; // MAC address, printed on a sticker on the shield
	IPAddress ip(192, 168, 10, 10); // ethernet shields wanted IP

Set mac and IP to your preference  

Hook up your arduino to your LAN and start it up  

Edit /var/www/html/piPowerTempLog/config.php  
Edit lines:  

	$powerUrl = 'http://192.168.10.10';  
	$powerPollReset = 'http://192.168.10.10/?pollReset';  

to either IP or hostname set before  

Resources
==========

Calculate burden resistor:
----------
>$ python resistor.py \<resistance\> \<tolerance\>













