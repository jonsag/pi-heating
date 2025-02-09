
#include "configuration.h"
#include "inputs.h"
#include "outputs.h"
#include "serial.h"

////////////////////////////// setup //////////////////////////////
void setup()
{
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

  Serial.println();
  Serial.println(programName); // print information
  Serial.println(date);
  Serial.print("by ");
  Serial.println(author);
  Serial.println(email);
  Serial.println();

  /*******************************
      Declare digital inputs
    *******************************/
  lcd.setCursor(0, 2);
  lcd.print("Starting in/outputs...");
  Serial.println("Defining digital in/outputs...");
  Serial.println();
  //pinMode(simulateRainButton, INPUT);
  //pinMode(rain0Button, INPUT);
  pinMode(anemometer, INPUT);
  pinMode(rainBucket, INPUT);
  pinMode(redLed, OUTPUT);

  lcd.setCursor(0, 3);
  lcd.print("Starting now...");
  delay(1000);

  /*******************************
      Print headlines to LCD
    *******************************/
  Serial.println("Printing headlines to LCD");
  Serial.println();
  lcd.clear();
  lcd.setCursor(0, 2);
  lcd.print("Rain: ");
  lcd.setCursor(17, 1);
  lcd.print("m/s");
  Serial.println("Start!");
  Serial.println();

  Serial.println("Enter h for help");
  Serial.println();
}

////////////////////////////// main loop //////////////////////////////
void loop()
{
  currentMillis = millis();

  inputs(); //read and evaluate inputs

  serial(); // read and print to serial

  outputs(); // blink LED and print to LCD

} // end of main loop
