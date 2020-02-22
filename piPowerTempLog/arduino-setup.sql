CREATE DATABASE if not exists arduino1;
GRANT USAGE ON *.* to arduino@localhost IDENTIFIED BY 'arduinopass';
GRANT ALL PRIVILEGES ON arduino1.* TO arduino@localhost WITH GRANT OPTION;
FLUSH PRIVILEGES;
ALTER DATABASE arduino1 DEFAULT CHARACTER SET latin1;
