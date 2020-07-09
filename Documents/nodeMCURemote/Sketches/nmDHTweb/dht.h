#include <DHTesp.h>; // library found at https://github.com/beegee-tokyo/DHTesp
DHTesp dht;

// Replaces placeholder with DHT values
String processor(const String& var) {
  //Serial.println(var);
  if (var == "TEMPERATURE") {
    return String(t);
  }
  else if (var == "HUMIDITY") {
    return String(h);
  }
  return String();
}
