/*
 The circuit:
 *                             GND            display pin 1
 *  supply voltage for logic   +5V            display pin 2

 * 10K resistor:
 * ends to +5V and ground
 * LCD VO - contrast           wiper          display pin 3

 * LCD RS pin                  digital pin 13 display pin 4
 * LCD R/W pin                 GND            display pin 5
 * LCD Enable pin              digital pin 12 display pin 6
 * LCD D4                      digital pin 11 display pin 11
 * LCD D5                      digital pin 10 display pin 12
 * LCD D6                      digital pin 9  display pin 13
 * LCD D7                      digital pin 8  display pin 14

 * 10K resistor:
 * ends to +5V and ground
 * back light anode:+4.2V      wiper          display pin 15
 * back light cathode          wiper          display pin 16
 */

#include <Average.h> // add library for calculating averages
#include <LiquidCrystal.h>

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(13, 12, 11, 10, 9, 8);

// declare in/outputs
int simulateRainButton = 7;
int rain0Button = 6;
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

////////////////////////////// setup //////////////////////////////
void setup() {
  // set up the LCD's number of columns and rows:
  Serial.println("Initializing LCD...");
  lcd.begin(20, 4);
  // Print a message to the LCD.
  lcd.print("Booting...");

  delay(5000);
  Serial.begin(9600);
  Serial.println("weather_station_no_temps_with_lcd_140122");
  lcd.setCursor(0, 1);
  lcd.print("Started serial");
  Serial.println("Started serial communication after waiting 5 seconds");
  lcd.setCursor(0, 2);
  lcd.print("Waiting...");
  Serial.println("Waiting another 5 seconds...");
  delay(5000);  //important on linux a serial port can lock up otherwise

  // declare digital inputs
  lcd.setCursor(0, 2);
  lcd.print("Starting in/outputs...");
  Serial.println("Defining digital in/outputs...");
  //pinMode(simulateRainButton, INPUT);
  //pinMode(rain0Button, INPUT);
  pinMode(anemometer, INPUT);
  pinMode(rainBucket, INPUT);
  pinMode(redLed, OUTPUT);

  lcd.setCursor(0, 3);
  lcd.print("Starting now...");
  delay(1000);

  // print headlines to LCD
  Serial.println("Printing headlines to LCD");
  lcd.clear();
  lcd.setCursor(0, 2);
  lcd.print("Rain: ");
  lcd.setCursor(17, 1);
  lcd.print("m/s");
  Serial.println("Start!");


  Serial.println("Enter h for help");
}

////////////////////////////// main loop //////////////////////////////
void loop() {
  currentMillis = millis();

  ///////////////////////// read inputs
  //simulateRainButtonState = digitalRead(simulateRainButton);
  //rain0ButtonState = digitalRead(rain0Button);
  anemometerState = digitalRead(anemometer);
  rainBucketState = digitalRead(rainBucket);
  vaneValue = analogRead(vane);

  /*
  Serial.print("rain0Button: ");
   Serial.print(rain0ButtonState);
   Serial.print("     ");
   Serial.print("simulateRainButton: ");
   Serial.print(simulateRainButtonState);
   Serial.println();
   */

  ///////////////////////// vane - wind direction
  directionValue = windDirection();
  if (vaneAverageCounter >= vaneSamples) {
    displayedVaneAverage = mean(vaneAverage,vaneAverageCounter),DEC;
    vaneAverageCounter = 0;
  }
  else {
    vaneAverage[vaneAverageCounter] = atoi(vaneDegrees[directionValue]);
    vaneAverageCounter++;
  }

  ///////////////////////// anemometer - wind speed
  if(anemometerState != lastAnemometerState && anemometerState == HIGH) { // if we have recieved a pulse
    anemometerPulses++;
    blinkRedLed = true;
  }
  lastAnemometerState = anemometerState; // save state to next run

  if(currentMillis - anemometerMillis >= 10000) {
    //anemometerPulsesPerSecond = anemometerPulses;
    windSpeed = anemometerPulses * 0.667 / 10; // one pulse is 0.667 m/s
    anemometerPulses = 0;
    anemometerMillis = currentMillis;
    windSpeedAverage += windSpeed;
    windSpeedAverageCounter ++;
  }

  ///////////////////////// rain gauge - tip bucket
  if(rainBucketState != lastrainBucketState && rainBucketState == HIGH) { // if we have recieved a pulse
    rainBucketTips++;
    totalRain += 0.279; // one pulse is 0.279 mm of rain
    rainSinceLastPoll += 0.279;
    rainIntensity = 60 * 0.279 / ((currentMillis - lastRainMillis) / 1000);
    lastRainMillis = currentMillis;
    blinkRedLed = true;
  }
  lastrainBucketState = rainBucketState; // save state for next run

  if((currentMillis - lastRainMillis) > 60000) { // if we haven't recieved a puse for 60 seconds, set intensity to 0
    rainIntensity = 0;
  }

  ///////////////////// check if reset rain meter button is pressed
  /* if (rain0ButtonState != lastRain0ButtonState) {
   if (rain0ButtonState == HIGH) {
   Serial.println("Resetting rain meter");
   totalRain = 0;
   //blinkRedLed = true;
   }
   }
   lastRain0ButtonState = rain0ButtonState;
   */

  ///////////////////// check serial for message
  if (Serial.available()) { // check if data has been sent from the computer
    byteRead = Serial.read(); // read the most recent byte
    if ( byteRead == 99 ) { // c outputs complete information
      serialPrintComplete();
    }
    else if ( byteRead == 104 ) { // h outputs help info
      help();
    }
    else if ( byteRead == 112 ) { // p does a poll
      poll();
    }
    else if ( byteRead == 101 ) { // e explains polling output
      explain();
    }
    /*
    else if ( byteRead == 115 ) { // s simulates rain
     totalRain += 0.279; // one pulse is 0.279 mm of rain
     rainSinceLastPoll += 0.279;
     }
     */
    else if ( byteRead == 114 ) { // r resets rain since last poll
      resetAll();
    }
    /*
     else if ( byteRead == 82 ) { // R resets rain total
     totalRain = 0;
     }
     */
    else {
      Serial.write(byteRead);
      Serial.println(" NA");
    }
  }

  ///////////////////// blink
  if (blinkRedLed || redLedOn) { // if we should light led or if it's already lit
    rainBlinking();
  }

  ///////////////////// print
  lcdPrint();

  ///////////////////// erase status line
  if (currentMillis - pollMillis >= 1000 ) {
    lcd.setCursor(0, 3);
    lcd.print("                    ");
  }

  ///////////////////// life tick
  tickPrint();

} // end of main loop

////////////////////////////// evaluate wind direction //////////////////////////////
int windDirection(void) {
  if(vaneValue >= 0 && vaneValue <= 50) { // ESE
    directionValue = 16;
  }
  else if(vaneValue >= 51 && vaneValue <= 59) { // ENE
    directionValue = 9;
  }
  else if(vaneValue >= 60 && vaneValue <= 75) { // E
    directionValue = 1;
  }
  else if(vaneValue >= 76 && vaneValue <= 115) { // SSE
    directionValue = 15;
  }
  else if(vaneValue >= 116 && vaneValue <= 155) { // SE
    directionValue = 8;
  }
  else if(vaneValue >= 156 && vaneValue <= 190) { // SSW
    directionValue = 14;
  }
  else if(vaneValue >= 191 && vaneValue <= 270) { // S
    directionValue = 4;
  }
  else if(vaneValue >= 271 && vaneValue <= 335) { // NNE
    directionValue = 10;
  }
  else if(vaneValue >= 336 && vaneValue <= 450) { // NE
    directionValue = 5;
  }
  else if(vaneValue >= 451 && vaneValue <= 510) { // WSW
    directionValue = 13;
  }
  else if(vaneValue >= 511 && vaneValue <= 570) { // SW
    directionValue = 7;
  }
  else if(vaneValue >= 571 && vaneValue <= 660) { // NNW
    directionValue = 11;
  }
  else if(vaneValue >= 661 && vaneValue <= 730) { // N
    directionValue = 2;
  }
  else if(vaneValue >= 731 && vaneValue <= 805) { // WNW
    directionValue = 12;
  }
  else if(vaneValue >= 806 && vaneValue <= 870) { // NW
    directionValue = 6;
  }
  else if(vaneValue >= 871 && vaneValue <= 1023) { // W
    directionValue = 3;
  }
  else {
    directionValue = 0;
  }
  return directionValue;
}

/////////////////////////////// blinking rain LED ///////////////////////////////
void rainBlinking(void) {
  if (redLedOn && blinkMillis - currentMillis >= 200) {
    digitalWrite(redLed, LOW);
    redLedOn = false;
  }
  else if(blinkRedLed) {
    digitalWrite(redLed, HIGH);
    blinkMillis = currentMillis;
    blinkRedLed = false;
    redLedOn = true;
  }
}

/////////////////////////////// print  complete output to serial ///////////////////////////////
void serialPrintComplete(void) {
  if(currentMillis - serialPrintMillis >= 1000) {
    //Serial.print(currentMillis);
    //Serial.print("    ");

    //Serial.print(vaneValue);
    //Serial.print("    ");
    Serial.print("Wind direction: ");
    Serial.print(vaneDirection[directionValue]);
    Serial.print("    ");
    Serial.print(vaneDegrees[directionValue]);
    Serial.print("    ");

    //Serial.print(anemometerState);
    //Serial.print("    ");
    //Serial.print(anemometerPulsesPerSecond);
    //Serial.print("    ");
    Serial.print("Wind speed: ");
    Serial.print(windSpeed);
    Serial.print(" m/s    ");
    Serial.print("Average wind speed: ");
    if(windSpeedAverageCounter != 0) {
      Serial.print(windSpeedAverage / windSpeedAverageCounter);
    }
    else {
      Serial.print(windSpeedAverage);
    }
    Serial.print(" m/s    ");
    Serial.print(",");
    Serial.print("Rain intensity: ");
    Serial.print(rainIntensity);
    Serial.print(" mm/min    ");
    //Serial.print(rainBucketState);
    //Serial.print("    ");
    //Serial.print(rainBucketTips);
    //Serial.print("    ");
    Serial.print("Rain total: ");
    Serial.print(totalRain);
    Serial.print(" mm    ");
    //Serial.print(currentMillis - lastRainMillis);
    //Serial.print("    ");

    Serial.println();

    //serialPrintMillis = currentMillis;
  }
}

/////////////////////////////// print to LCD ///////////////////////////////
void lcdPrint(void) {
  //lcd.setCursor(0, 0);
  //lcd.print(currentMillis);

  if(currentMillis - lcdPrintMillis >= 1000) {
    ///// print wind
    lcd.setCursor(0, 1);
    lcd.print("   ");
    lcd.setCursor(0, 1);
    lcd.print(vaneDirection[directionValue]);

    //length = getLength(vaneDirection[directionValue]);
    lcd.setCursor(4, 1);
    lcd.print("   ");
    length1 = getLength(displayedVaneAverage);
    lcd.setCursor(7 - length1, 1);
    lcd.print(displayedVaneAverage);

    lcd.setCursor(7, 1);
    lcd.print((char)223);

    lcd.setCursor(12, 1);
    //windSpeed = 8.43;
    lcd.print(windSpeed);
    //length = 3 + getLength(windSpeed);

    ///// print rain
    lcd.setCursor(6, 2);
    lcd.print(totalRain);

    lcdPrintMillis = currentMillis;
  }
}

/////////////////////////////// get length ///////////////////////////////
int getLength(int value) {
  int length;

  if(value > 9999)
    length = 5;
  else if(value > 999)
    length = 4;
  else if(value > 99)
    length = 3;
  else if(value > 9)
    length = 2;
  else
    length = 1;

  return length;
}

/////////////////////////////// help ///////////////////////////////
void help(void) {
  Serial.println("---------- help ----------");
  Serial.println("Enter c for complete output");
  Serial.println("Enter p to simulate a poll");
  Serial.println("Enter e to explane poll output");
  //Serial.println("Enter s to simulate rain");
  Serial.println("Enter r to reset rain since last poll");
  //Serial.println("Enter R to reset rain total");
  Serial.println("Enter h for this help");
  Serial.println("--------------------------");
}

/////////////////////////////// explain ///////////////////////////////
void explain(void) {
  Serial.print("pollStart");
  Serial.print(",");
  Serial.print("Wind direction");
  Serial.print(",");
  Serial.print("Wind direction degrees");
  Serial.print(",");
  Serial.print("Average wind direction degrees");
  Serial.print(",");
  Serial.print("Wind speed");
  Serial.print(",");
  Serial.print("Average wind speed");
  Serial.print(",");
  Serial.print("Rain since last poll");
  Serial.print(",");
  //Serial.print("Rain intensity");
  //Serial.print(",");
  Serial.print("pollEnd");
  Serial.println();
}

/////////////////////////////// poll ///////////////////////////////
void poll(void) {
  polled = true;
  lcd.setCursor(0, 3);
  lcd.print("Polled from serial");

  Serial.print("pollStart");
  Serial.print(",");
  Serial.print(vaneDirection[directionValue]);
  Serial.print(",");
  Serial.print(vaneDegrees[directionValue]);
  Serial.print(",");
  Serial.print(displayedVaneAverage);
  Serial.print(",");
  Serial.print(windSpeed);
  Serial.print(",");
  if(windSpeedAverageCounter != 0) {
    Serial.print(windSpeedAverage / windSpeedAverageCounter);
  }
  else {
    Serial.print(windSpeedAverage);
  }
  Serial.print(",");
  Serial.print(rainSinceLastPoll);
  Serial.print(",");
  //Serial.print(rainIntensity);
  //Serial.print(",");
  Serial.print("pollEnd");
  Serial.println();
  pollMillis = currentMillis;
}

/////////////////////////////// tick on lcd ///////////////////////////////
void tickPrint(void) {
  if(currentMillis - tickMillis > 2000) {
    tickMillis = currentMillis;
  }

  if(currentMillis - tickMillis > 1000) {
    tick = 219;
  }
  else {
    tick = 165;
  }

  if(tick != lastTick) {
    lcd.setCursor(19, 0);
    lcd.print((char)tick);
    //lcd.print(tick);
  }
  lastTick = tick;
}

/////////////////////////////// reset values after poll ///////////////////////////////
void resetAll(void) {
  rainSinceLastPoll = 0;
  windSpeedAverage = 0;
  windSpeedAverageCounter = 0;
  Serial.println("Values reset");
}






