// Import required libraries
#include <Arduino.h>
#include <Hash.h>
#include <Adafruit_Sensor.h>

/***********
   Sensors
 ***********/
const int numberOfSensors = 1;
const String sensor1Name = "nodeMCU 1";

/***********
   DHT config
 ***********/
const int dhtPin = 0; // Connect DHT sensor to GPIO0, D3

/***********
   Web server
 ***********/
 const int serverPort = 8081;

/***********
   Misc
 ***********/
// current temperature & humidity, updated in loop()
float t = 0.0;
float h = 0.0;

// Generally, you should use "unsigned long" for variables that hold time
// The value will quickly become too large for an int to store
unsigned long previousMillis = 0;    // will store last time DHT was updated

// Updates DHT readings every 10 seconds
const long interval = 10000;
