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

Edit  

 	/home/pi/piHeatingRemote/configs/sensors
 
 and insert serials and names, for example  

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

Configuration
==========
In a browser, go to  

	http://\<IP\>:8080/status.php
	
Adding sensors
----------
Click  

	Input Sensors
	
and then  

	Scan for new sensors
	
After scanning click  

	Done
	
Adding devices
----------
Click  

	Output Devices
	
Click  

	Add new
	
Click  

	Edit
	
on the new one just added.
Fill in all the fields and then click  

	Save
	
and then  

	Done

twice.
	
>Note: pin numbers are used, NOT GPIO numbers.
If using the piHeatingLCD hat, the one output device is at GPIO15, pin 10, and it it active HIGH, so you would set H/L to 1.  
















