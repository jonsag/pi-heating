/*******************************
  Request temperatures
*******************************/
void getTemperatures(void)
{
  digitalWrite(yellowPinTemp, HIGH); // turn yellow LED on

  tempsMillis = currentMillis; // save the last time you synced time

  Serial.println("--- Requesting temperatures...");

  sensors.requestTemperatures(); // Send the command to get temperatures

  for (i = 0; i < numberOfSensors; i++)
  { // read each of our sensors and print the value
    Serial.print("Temperature for Device ");
    Serial.print(i);
    Serial.print(" is: ");
    tempValue[i] = sensors.getTempCByIndex(i);
    Serial.println(tempValue[i]);
  }
  Serial.println();

  tempsRead = true;
  digitalWrite(yellowPinTemp, LOW); // turn yellow LED off
  readTemps = false;
}
