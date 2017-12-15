# pi-heating
Some scripts tweaked from https://github.com/JeffreyPowell


Installation
-----------------------------
$ wget "https://github.com/jonsag/pi-heating/archive/0.2.tar.gz" -O "/home/pi/pi-heating.tar.gz"
$ cd /home/pi
$ tar -xvzf pi-heating.tar.gz
or
$ cd /home/pi
$ git clone https://github.com/jonsag/pi-heating.git


On pi running as hub or hub/remote:
$ sudo pi-heating/pi-heating-hub-install.sh
$ sudo pi-heating/pi-heating-hub-mysql-install.sh
$ sudo pi-heating/pi-heating-hub-secure.sh


If hub also will have extended weather and power logging:
$ sudo pi-heating/pi-heating-extende-log-install.sh
		wget "http://www.triconsole.com/php/calendar_download.php" -O "/home/pi/calendar.zip"


On pi running solely as remote or as hub/remote:
$ sudo pi-heating/pi-heating-remote-install.sh


$ rsync -rci ~/Documents/EclipseWorkspace/pi-heating/pi-heating-hub-extended-log/www/* pi@raspberry03:/var/www/pi-heating-hub-extended-log/


below works
SELECT value AS temp5 
FROM tempLog 
WHERE 
sensorid='5' 
AND  
ts IN (SELECT DISTINCT(ts) AS ts FROM tempLog WHERE DATE(ts) = CURDATE())

SELECT ts, 
       MAX(CASE WHEN sensorid = 3 THEN value ELSE 0 END) AS sensor3,
       MAX(CASE WHEN sensorid = 4 THEN value ELSE 0 END) AS sensor4,
       MAX(CASE WHEN sensorid = 5 THEN value ELSE 0 END) AS sensor5
FROM tempLog
GROUP BY ts








