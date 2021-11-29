#include <OneWire.h>
#include <DallasTemperature.h>

// Setup a oneWire instance to communicate with any OneWire devices
OneWire oneWire(dsPin);

// Pass our oneWire reference to Dallas Temperature.
DallasTemperature sensors(&oneWire);

float readTemp(int sensorNo)
{
  return sensors.getTempC(deviceAddresses[sensorNo]);
}
