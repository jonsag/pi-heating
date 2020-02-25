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


Check settings and install sketch:
-----------------------------
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

>$ rsync -rci ~/Documents/EclipseWorkspace/pi-heating/piHeatingHub-extended-log/www/* pi@raspberry03:/var/www/html/piHeatingHub-extended-log/  
>$ rsync -rci ~/Documents/EclipseWorkspace/pi-heating/piHeatingHub/www/* pi@raspberry03:/var/www/html/piHeatingHub/  

>$ rsync -raci ~/Documents/EclipseWorkspace/pi-heating/pi-heating-LCD/* pi@raspberry05:/home/pi/pi-heating-LCD/  