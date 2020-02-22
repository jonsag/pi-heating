String programName = "ardCurrentTempLog";
String date = "20200221";
String author = "Jon Sagebrand";
String email = "jonsagebrand@gmail.com";

/*
  Define these variables down in the code:
  ------------------------------------
  byte mac[] = -----the hex numbers on the sticker on your ethernet shield
  IPAddress ip( ----- the IP number you want yor arduino board to use
  if ( pollAge > 600000 ----- how long is the intervals between automatic reset of puls counting, milliseconds
  if (!tempsRead || tempAge > 60000 -----how often should we reset temps, milliseconds

  intervals - millis() - milliseconds:
  ------------------------------------
  10 seconds = 10000
  1 min = 60000
  5 min = 300000
  10 min = 600000
  1 hour = 3600000
  1 day = 86400000
  1 week = 604800000

  LEDs
  ------------------------------------
  YELLOW - discovering or reading temp sensors
  GREEN - activity on internet interface
  RED - pulse recieved
*/

#include <SPI.h> // ethernet libraries    
#include <Dhcp.h>
#include <Dns.h>
#include <Ethernet.h>
#include <EthernetServer.h>
//#include <EthernetUdp.h>
#include <OneWire.h> // oneWire libraries
#include <DallasTemperature.h>
//#include <util.h>
//#include <Time.h> // time library

/*******************************
  Ethernet settings
*******************************/
byte mac[] = {
  0x90, 0xA2, 0xDA, 0x0C, 0x00, 0x76
}; // MAC address, printed on a sticker on the shield
IPAddress ip(192, 168, 10, 10); // ethernet shields wanted IP
//IPAddress gateway(192,168,10,1); // internet access via router
//IPAddress subnet(255,255,255,0); //subnet mask
EthernetServer server(80); // this arduinos web server port
String readString; // string read from servers interface

/*******************************
  OneWire settings
*******************************/
#define ONE_WIRE_BUS 2 // oneWire bus bin
OneWire oneWire(ONE_WIRE_BUS); // setup oneWire instance to communicate with any OneWire devices
DallasTemperature sensors(&oneWire); // pass our oneWire reference to Dallas Temperature
byte numberOfSensors; // will store how many sensors we have
float tempValue[] = { // will store the temps
  0, 1, 2, 3
};
boolean tempsRead = false; // will be true after first temp reading
byte present = 0;
byte data[12];
byte addr[8];
byte count = 0;

/*******************************
  Pin numbers
*******************************/
const int pinPulse = 4; // number of the pin connected to the photo transistor
const int yellowPinTemp =  7;      // number of the yellow LED pin, status
const int greenPinNetwork =  8;      // number of the green LED pin, polled
const int redPinPulse =  9;      // number of the red LED pin, pulse recieved

/*******************************
  Current clamps inputs
*******************************/
const int phase[] = {
  A1, A2, A3
};

/*******************************
  Current values variables
*******************************/
double currentReading; 

double displayedCurrent[] = { // the displayed value on the web page
  1, 2, 3
};
double ackDisplayedCurrent[] = { // all reads ackumulated
  1, 2, 3
};
double polledCurrent[] = { // the average current between each poll
  1, 2, 3
};
double ackPolledCurrent[] = { // all averages ackumulated
  1, 2, 3
};

int readAverageCounter = 200; // counter for how many readings should be averaged

/*******************************
  Misc variables
*******************************/
int pulseButtonState = 0; // variable for reading pulse button status
int lastPulseButtonState = 0; // saves pulse buttons previous state
byte pulseState = 0;
int lastPulseState = 0;
int syncButtonState = 0; // variable for reading sync button status

int ledStateYellow = LOW; // ledState holds the LED outputs
int ledStateGreen = LOW;
int ledStateRed = LOW;

boolean blinkRed = false; // blink the LEDs
boolean blinkGreen = false;
boolean blinkYellow = false;

int blinkRedCounter = 0; // counters for blinks of the LEDs
int blinkGreenCounter = 0;
int blinkYellowCounter = 0;
int blinkYellowOffCounter = 0;

/*******************************
  Times variables
*******************************/
unsigned long currentMillis = 000000; // will store millis()

unsigned long pollMillis = 000000; // will store last time resetInterval was reset
unsigned long pollAge = 000000; // how long since last poll

unsigned long tempsMillis = 000000; // will store last time temps was read
unsigned long tempAge = 000000; // how long since the temps was read

unsigned int pulsesLastPoll = 0; // various pulse counters, 1 pulse = 1/1000 kwh
unsigned int pulses = 0;

/*******************************
  Counter variables
*******************************/
int i = 0; // various purposes
byte phaseCount = 0; // counting throug the 3 phases
byte tempsCounter = 0; // counter for displaying values on web page
int currentDisplayedCounter = 0; // counter for displayed current average
unsigned long currentPollCounter = 0; // counter för current interval average
unsigned int readCounter = 0; // counter for how often to read currents
boolean readTemps = false;
