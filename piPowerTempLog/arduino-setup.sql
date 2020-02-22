CREATE DATABASE if not exists CurrentTempLog;
GRANT USAGE ON *.* to arduino@localhost IDENTIFIED BY 'arduinopass';
GRANT ALL PRIVILEGES ON CurrentTempLog.* TO arduino@localhost WITH GRANT OPTION;
FLUSH PRIVILEGES;
ALTER DATABASE CurrentTempLog DEFAULT CHARACTER SET latin1;
