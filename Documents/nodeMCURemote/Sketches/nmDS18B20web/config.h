String programName = "nmDS18B20web";
String date = "20200711";
String author = "Jon Sagebrand";
String email = "jonsagebrand@gmail.com";

/***********
   DS18B20 sensors
 ***********/
const int dsPin = 0; // Connect DHT sensor to GPIO0, D3

/*
   Sensor 0: 0x28, 0xFF, 0xE1, 0x19, 0x03, 0x17, 0x03, 0x70
   Sensor 1: 0x28, 0xFF, 0x85, 0x41, 0xB5, 0x16, 0x05, 0xCE
   Sensor 2: 0x28, 0xFF, 0xEF, 0x22, 0xB5, 0x16, 0x05, 0x7A
*/

float tempSensor0, tempSensor1, tempSensor2;

uint8_t sensor0[8] = { 0x28, 0xFF, 0xE1, 0x19, 0x03, 0x17, 0x03, 0x70 };
uint8_t sensor1[8] = { 0x28, 0xFF, 0x85, 0x41, 0xB5, 0x16, 0x05, 0xCE };
uint8_t sensor2[8] = { 0x28, 0xFF, 0xEF, 0x22, 0xB5, 0x16, 0x05, 0x7A };

String devicePlaces[] = {"Boden", "Ute", "VVB"};
uint8_t deviceAddresses[][8] = { { 0x28, 0xFF, 0xE1, 0x19, 0x03, 0x17, 0x03, 0x70 }, { 0x28, 0xFF, 0x85, 0x41, 0xB5, 0x16, 0x05, 0xCE }, { 0x28, 0xFF, 0xEF, 0x22, 0xB5, 0x16, 0x05, 0x7A }};

/***********
   Web server
 ***********/
 const int serverPort = 8081;
