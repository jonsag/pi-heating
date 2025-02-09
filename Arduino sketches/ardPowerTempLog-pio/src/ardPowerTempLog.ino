#include "configuration.h" // sets all variables
//#include "OneWireDiscover.h"
#include "blink.h"
//#include "getTemps.h"
#include "readCurr.h"
#include "webPage.h"

//////////////////////////////////// setup ////////////////////////////////////
void setup()
{
  /*******************************
    Start serial
  *******************************/
  Serial.begin(9600);

  Serial.println();
  Serial.println("---------- Starting ----------");
  Serial.println(programName); // print information
  Serial.println(date);
  Serial.print("by ");
  Serial.println(author);
  Serial.println(email);
  Serial.println();

  Serial.println("Started serial communication");
  Serial.println();

  /*******************************
    Start in- outputs
  *******************************/
  Serial.println("Initiating in/outputs...");
  pinMode(pinPulse, INPUT);
  //pinMode(yellowPinTemp, OUTPUT); // initialize the LED pins as outputs
  pinMode(greenPinNetwork, OUTPUT);
  pinMode(redPinPulse, OUTPUT);
  Serial.println();

  /*******************************
    Start 1-wire
  *******************************/
  /*Serial.println("Starting 1-wire sensors...");
    sensors.begin(); // start up the oneWire library
    Serial.println();

    Serial.println("Discovering and counting sensors...");
    numberOfSensors = discoverOneWireDevices(); // count sensors
    Serial.println();*/

  /*******************************
    Wait for stability
  *******************************/
  Serial.println("Waiting 5 seconds...");
  delay(5000); //important on linux a serial port can lock up otherwise
  Serial.println();

  /*******************************
    Start ethernet
  *******************************/
  Serial.print("Starting ethernet with IP: ");
  Serial.print(ip);
  Serial.println(" ...");
  Ethernet.begin(mac, ip);
  Serial.println();

  /*******************************
    Start webserver
  *******************************/
  Serial.println("Starting web server...");
  server.begin(); //start arduinos web server
  Serial.println();

  /*******************************
    Finished starting
  *******************************/
  Serial.println("Starting...");
  Serial.println();
}

/*******************************
  Main
*******************************/
void loop()
{
  /*******************************
    Check some times
  *******************************/
  currentMillis = millis();               // millis right now
  pollAge = (currentMillis - pollMillis); // how much time elapsed since last log write
  //tempAge = (currentMillis - tempsMillis); // how much time elapsed since last temp reading

  /*******************************
    Read digital inputs
  *******************************/
  pulseState = digitalRead(pinPulse); // read pulse input

  /*******************************
    Read analog values
  *******************************/
  //if (!readTemps) {
  readCurrents();
  //}

  /*******************************
    Check for pulse
  *******************************/
  if (pulseState != lastPulseState)
  { // light red LED if button is pressed
    if (pulseState == HIGH)
    {           // if the current state is HIGH then the button went from off to on
      pulses++; // +1 on puls counter
      Serial.print("Pulse received, pulses this interval is now ");
      Serial.println(pulses);
      blinkRed = true;
    }
  }
  lastPulseState = pulseState; // save pulse button state till next loop

  /*******************************
    Check if it's time to reset pulses
  *******************************/
  if (pollAge > 600000)
  {
    pollMillis = currentMillis;
    Serial.println("---Resetting pulses");
    pulsesLastPoll = pulses;
    pulses = 0;
  }

  /*******************************
    Check if it's time to read temps
  *******************************/
  /*if (!tempsRead || tempAge > 60000) { // read temperatures if we haven't before, or if it's time to do so
    readTemps = true;
    getTemperatures();
    }*/

  /*******************************
    Blink LEDs
  *******************************/
  blinkLEDs();

  /*******************************
    Web server
  *******************************/
  presentWebPage();

} // end of main loop
