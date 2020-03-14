piHeatingLCD

The LCD and buttons will work if:  
----------
* you have a schedule that always keep a low temperature  
* you have a single mode that pulls up the temperature  
* you have a single timer that pulls up the temperature  

Install
==========
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
Build according to files in  

	Documents
	
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

Web configuration
==========
In a browser, go to  

	http://\<IP\>:8080/status.php

Add sensor
----------	
Log in with user 'admin' and the password you set up during the hub installation.  

Click  

	Input Sensors
	Scan for new sensors
	
When sensor is found, click  

	Done
	
Add devices
----------
Click  

	Output Devices
	
Click  

	Add new
	
Click  

	Edit
	
on the newly added device.  
Set  
	Name: \<name\>
	GPIO Pin: 10
	Pin Active H/L: 1

Click  

	Save
	Done
	Done	

Add mode
----------
Click  

	Modes
	Add new
	
Click  

	Edit
	
on the newly added mode, and set  

	Name: \<name\>
	
, for example 'Warm' to indicate it will be sued to pull up the temperature.

Then click  

	Done
	
Add schedules
----------
Click  

	Schedules
	Add new
	
Click  

	Edit
	
on the newly created schedule.  

This will be the schedule that pulls up the temperature once a week.  
Enter

	Name: \<name\>
	Start time: \<some time before the temeprature must be reached\>
	End time: \<the time when the temperature can strt dropping\>
	Repeat schedule every: \<the day in question\>
	When sensors: IS LESS THAN \<the temperature you want to keep\>
	AND Timers: IS IGNORED
	Activate Devices: \<mark the device you created before\>
	AND Modes: \<\>
	
Click  

	Save
	Done
	
Once again, click  

	Schedules
	Add new
	
Click  

	Edit
	
on the newly created schedule.  

This will be the schedule that keeps the temperature to a lower temp for energy savings.  

Note
==========
If you install on Raspberry Pi rev 1, you must edit  

	piHeatingLCD/config.ini
	
Change line from  

	lcd_d6        = 27
	
to  

	lcd_d6        = 21
	






