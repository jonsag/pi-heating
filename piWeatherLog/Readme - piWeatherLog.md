piWeatherLog

Install
-----------------------------
>$ sudo ./piWeatherLog.sh  

Reboot RaspberryPi  

Connect the Arduino Weather Sensor to RPi  

Find out tty-device  
>$ dmesg | grep tty  

Probably named someting like '/dev/ttyACM0'  
If not as above, edit  

	/var/www/piWeatherLog/weather.php  
	
Change line  

	$serial->deviceSet("/dev/ttyACM0");  

so it matches the output from dmesg command  


Install sketch on Arduino
-----------------------------
Install Average library from  

	~/pi-heating/Resources/Arduino/libraries  

to your Arduino IDE  

Open sketch  

	~/pi-heating/piWeatherLog/ardWeatherLog  

Select Board and Port  	
Compile and upload to arduino  

Check Arduino output
==========
Connect to arduino with screen:  
>$ screen /dev/ttyACM0 9600 -S <session name>  

To get screen command promp, enter  
[C-a] :  
Then type  
quit  
and [Return]  
	or from outside of screen  
>$ screen -X -S <session name> quit  

Kill screen with ^ak or control-a k    
