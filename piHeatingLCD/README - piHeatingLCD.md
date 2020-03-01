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







