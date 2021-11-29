#include <Arduino.h>

#include "config.h"

/* Add a file in this directory, called 'wifiConfig.h'
    This file shpould include two lines, setting your SSID and wifi password:

    const char* ssid = "SSID_name";
    const char* password = "Wifi_password";

    Update these with values suitable for your network.
*/
#include "wifiConfig.h"

#include "wifi.h"
#include "dallas.h"
#include "webServer.h"

void setup() {
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

  delay(100);

  /*******************************
    Start DS18B20 sensors
  *******************************/
  sensors.begin();

  /*******************************
    Start WiFi
  *******************************/
  setup_wifi();

  /*******************************
    Set up and start web server
  *******************************/
  initiateServer();

  Serial.print("Number of places: ");
  Serial.println(sizeof(deviceNames) / sizeof(deviceNames[0]));
  Serial.print("Number of sensors: ");
  Serial.println(sizeof(deviceAddresses) / sizeof(deviceAddresses[0]));
  Serial.println();
  
  Serial.println("Sensor addresses: ");
  for (int i = 0; i < (sizeof(deviceAddresses) / sizeof(deviceAddresses[0])); i++) {
    Serial.print(deviceNames[i]);
    Serial.print(": ");
    printAddress(deviceAddresses[i]);
  }
  Serial.println();
  
  Serial.println("Temperatures: ");
  for (int i = 0; i < (sizeof(deviceAddresses) / sizeof(deviceAddresses[0])); i++) {
    Serial.print(deviceNames[i]);
    Serial.print(": ");
    Serial.println(readTemp(i));
  }
  Serial.println();

}
void loop() {
}

void printAddress(DeviceAddress deviceAddress) {
  for (uint8_t i = 0; i < 8; i++) {
    Serial.print("0x");
    if (deviceAddress[i] < 0x10) Serial.print("0");
    Serial.print(deviceAddress[i], HEX);
    if (i < 7) Serial.print(", ");
  }
  Serial.println("");
}

String SendHTML(float tempSensor0, float tempSensor1, float tempSensor2) {
  String ptr = "<!DOCTYPE html> <html>\n";
  ptr += "<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">\n";
  ptr += "<title>ESP8266 Temperature Monitor</title>\n";
  ptr += "<style>html { font-family: Helvetica; display: inline-block; margin: 0px auto; text-align: center;}\n";
  ptr += "body{margin-top: 50px;} h1 {color: #444444;margin: 50px auto 30px;}\n";
  ptr += "p {font-size: 24px;color: #444444;margin-bottom: 10px;}\n";
  ptr += "</style>\n";
  ptr += "</head>\n";
  ptr += "<body>\n";
  ptr += "<div id=\"webpage\">\n";
  ptr += "<h1>ESP8266 Temperature Monitor</h1>\n";
  ptr += "<p>Living Room: ";
  ptr += tempSensor0;
  ptr += "&deg;C</p>";
  ptr += "<p>Bedroom: ";
  ptr += tempSensor1;
  ptr += "&deg;C</p>";
  ptr += "<p>Kitchen: ";
  ptr += tempSensor2;
  ptr += "&deg;C</p>";
  ptr += "</div>\n";
  ptr += "</body>\n";
  ptr += "</html>\n";
  return ptr;
}
