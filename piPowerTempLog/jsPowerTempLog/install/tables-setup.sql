CREATE TABLE IF NOT EXISTS powerLog (
        id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        ts TIMESTAMP,
	currentR1 FLOAT,
	currentS2 FLOAT,
	currentT3 FLOAT,
	currentAverageR1 FLOAT,
	currentAverageS2 FLOAT,
	currentAverageT3 FLOAT,
	temp FLOAT,
	pulses INT,
	event char(255),
        PRIMARY KEY (id)
) CHARACTER SET UTF8;

CREATE TABLE IF NOT EXISTS tempLog (
        id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        ts TIMESTAMP,
	temp0 FLOAT,
        temp1 FLOAT,
        temp2 FLOAT,
        temp3 FLOAT,
        temp4 FLOAT,
        temp5 FLOAT,
        temp6 FLOAT,
        temp7 FLOAT,
        temp8 FLOAT,
        temp9 FLOAT,
        temp10 FLOAT,
        event char(255),
        PRIMARY KEY (id)
) CHARACTER SET UTF8;

CREATE TABLE IF NOT EXISTS 1wireDevices (
       id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
       devicePath char(15),
       deviceType char(20),
       place char(50),
       PRIMARY KEY (id)
) CHARACTER SET UTF8;

CREATE TABLE IF NOT EXISTS weatherLog (
       id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
       ts TIMESTAMP,
       windDirection char(3),
       windDirectionValue FLOAT,
       averageWindDirectionValue FLOAT,
       windSpeed FLOAT,
       averageWindSpeed FLOAT,
       rainSinceLast FLOAT,
       temp FLOAT,
       event char(255),
       PRIMARY KEY (id)
) CHARACTER SET UTF8;
