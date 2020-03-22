String programName = "ardWeatherStation";
String date = "20200316";
String author = "Jon Sagebrand";
String email = "jonsagebrand@gmail.com";

/*******************************
   Load libraries
 *******************************/
#include <Average.h> // include library for calculating averages

/*******************************
   LCD setup
 *******************************/
#include <LiquidCrystal.h> // include the LCD library
// set LCD pins
int LCD_RS = 13; // LCD RS, pin 4
int LCD_EN = 12; // LCD E, pin 6, Enable
int LCD_D4 = 11; // LCD D4, pin 11, databit 4
int LCD_D5 = 10; // LCD D5, pin 12, databit 5
int LCD_D6 = 9; // LCD D6, pin 13, databit 6
int LCD_D7 = 8; // LCD D7, pin 14, databit7
/* other pins on LCD are:
   VSS, pin 1, GND
   VDD, pin 2, +5V
   V0, pin 3, 10k potentiometer, ends to +5V and GND, middle pin to V0, contrast
   R/W, pin 5, GND, Read/Write
   A, pin 15, 220ohm resistor, one end to +5V, other to A, back light anode, ~+4.2V
   K, pin 16, GND, back light cathode
   D0, pin 7, databit 0, not used/connected
   D1, pin 8, databit 1, not used/connected
   D2, pin 9, databit 2, not used/connected
   D3, pin 10, databit 3, not used/connected
*/
// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(LCD_RS, LCD_EN, LCD_D4, LCD_D5, LCD_D6, LCD_D7);
// columns and rows of the LCD
int lcdColumns = 20;
int lcdRows = 4;

// declare in/outputs
//int simulateRainButton = 7;
//int rain0Button = 6;
int anemometer = 5;
int rainBucket = 4;
// digital 3 reserved for 1-wire
int redLed = 2;
int vane = A2;

int anemometerState = 0;
int lastAnemometerState = 0;
int anemometerPulses = 0;
//int anemometerPulsesPerSecond = 0;
float windSpeed = 0; // the speed in m/s
float windSpeedAverage = 0; // the average speed in m/s
int windSpeedAverageCounter = 0;
/*
int beaufort = 0;
 char* windLabels[] = {
 "Calm", "Light air", "Light breeze", "Gentle breeze", "Moderate breeze", "Fresh breeze", "Strong breeze", "High wind, moderate gale, near gale", "Gale, fresh gale", "Strong gale", "Storm, whole gale", "Violent storm", "Hurricane force"};
 char* svWindLabels[] = {
 "Lugnt", "Svag vind", "Svag vind", "Måttlig vind", "Måttlig vind", "Frisk vind", "Frisk vind", "Hård vind", "Hård vind", "Mycket hård vind", "Storm", "Svår storm", "Orkan"};
 char* svWindLabelsAtSea[] = {
 "Stiltje, bleke", "Nästan stiltje", "Lätt (laber) bris", "God bris", "Frisk bris", "Styv bris", "Hård bris, frisk kuling/kultje", "Styv kuling/kultje", "Hård kuling/kultje", "Halv storm", "Storm", "Svår storm", "Orkan"};
 */

//int simulateRainButtonState = 0;
//int lastSimulateRainButtonState = 0;

//int rain0ButtonState = 0;
//int lastRain0ButtonState = 0;

int rainBucketState = 0;
int lastrainBucketState = 0;
int rainBucketTips = 0;
float totalRain = 0;
float rainSinceLastPoll = 0;
int rainIntensity = 0;

int vaneValue = 0;
int directionValue = 0;
char* vaneDirection[]={
  "NA", "E", "N", "W", "S", "NE", "NW", "SW", "SE", "ENE", "NNE", "NNW", "WNW", "WSW", "SSW", "SSE", "ESE"};
char* vaneDegrees[]={
  "NA", "90", "0", "270", "180", "45", "315", "225", "135", "67.5", "22.5", "337.5", "292.5", "247.5", "202.5", "157.5", "112.5"};
int vaneAverageCounter = 0;
#define vaneSamples 100
int vaneAverage[vaneSamples];
int displayedVaneAverage = 0;

unsigned long currentMillis = 000000; // will store millis()
unsigned long anemometerMillis = 000000;
unsigned long lastRainMillis = 000000;
unsigned long blinkMillis = 000000;
unsigned long serialPrintMillis = 000000;
unsigned long lcdPrintMillis = 000000;
unsigned long pollMillis = 000000;
unsigned long tickMillis = 000000;

boolean blinkRedLed = false;
boolean redLedOn = false;
boolean polled = false;

int length1 = 0;
int length2 = 0;

byte byteRead; // stores data coming from serial

int tick = 0;
int lastTick = 0;
