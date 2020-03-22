piWeatherLog

Install
-----------------------------
>$ sudo ./pi-heating-weather-install.sh  

Add apache user to dialout and tty group  
>$ sudo usermod -a -G dialout, tty www-data  

Reboot pi  

Find out tty-device  
>$ dmesg | grep tty  

Probably named someting like '/dev/ttyACM0'  
Edit /var/www/pi-heating-weather/weather.php  
Change line 32  

	define("PORT","/dev/ttyACM0");  

so it matches the output from above  


Install sketch:
-----------------------------
Install Average library from https://github.com/MajenkoLibraries/Average  

Select Board and Port  
Open sketch  
Compile and upload to arduino  

>$ stty -F /dev/ttyACM0 ispeed 9600 ospeed 9600 -ignpar cs8 -cstopb -echo  

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
