
#include "configuration.h"
#include "inputs.h"
#include "lcd.h"
#include "serial.h"

////////////////////////////// setup //////////////////////////////
void setup() {
  /*******************************
    Start LCD
  *******************************/
  lcd.begin(lcdColumns, lcdRows);
  lcd.setCursor(0, 0); // print name of this program and boot message to the LCD
  lcd.print(programName);
  lcd.setCursor(0, 1);
  lcd.print("Booting ...");

  /*******************************
    Start serial
  *******************************/
  lcd.setCursor(0, 1);
  lcd.print("Starting serial ");
  
  Serial.begin(9600);

  Serial.println(programName); // print information
  Serial.println(date);
  Serial.print("by ");
  Serial.print(author);
  Serial.println(email);

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

  inputs(); //read and evaluate inputs

  serial(); // read and print to serial

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
