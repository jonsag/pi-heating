// adapted from https://lastminuteengineers.com/multiple-ds18b20-esp8266-nodemcu-tutorial/

#include "config.h";

#include <OneWire.h>
#include <DallasTemperature.h>

// Setup a oneWire instance to communicate with any OneWire devices
OneWire oneWire(dsPin);

// Pass our oneWire reference to Dallas Temperature.
DallasTemperature sensors(&oneWire);

DeviceAddress Thermometer; // variable to hold device addresses

void setup(void)
{
  /*******************************
    Start serial
  *******************************/
  Serial.begin(115200);

  Serial.println("");
  Serial.println("---------- Starting ----------");
  Serial.println(programName); // print information
  Serial.println(date);
  Serial.print("by ");
  Serial.println(author);
  Serial.println(email);
  Serial.println();

  Serial.println("Started serial communication");
  Serial.println("");

  // Start up the library
  sensors.begin();

  // locate devices on the bus
  Serial.println("Locating devices...");
  Serial.print("Found ");
  deviceCount = sensors.getDeviceCount();
  Serial.print(deviceCount, DEC);
  Serial.println(" devices");
  Serial.println("");

  Serial.println("Printing addresses...");
  for (int i = 0;  i < deviceCount;  i++)
  {
    Serial.print("Sensor ");
    Serial.print(i);
    Serial.print(": ");
    sensors.getAddress(Thermometer, i);
    printAddress(Thermometer);
  }
  Serial.println();
}

void loop(void)
{ }

void printAddress(DeviceAddress deviceAddress)
{
  for (uint8_t i = 0; i < 8; i++)
  {
    Serial.print("0x");
    if (deviceAddress[i] < 0x10) Serial.print("0");
    Serial.print(deviceAddress[i], HEX);
    if (i < 7) Serial.print(", ");
  }
  Serial.println("");
}
