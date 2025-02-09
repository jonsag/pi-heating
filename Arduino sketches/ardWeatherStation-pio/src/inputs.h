

////////////////////////////// evaluate wind direction //////////////////////////////
int windDirection()
{
  if (vaneValue >= 0 && vaneValue <= 50)
  { // ESE
    directionValue = 16;
  }
  else if (vaneValue >= 51 && vaneValue <= 59)
  { // ENE
    directionValue = 9;
  }
  else if (vaneValue >= 60 && vaneValue <= 75)
  { // E
    directionValue = 1;
  }
  else if (vaneValue >= 76 && vaneValue <= 115)
  { // SSE
    directionValue = 15;
  }
  else if (vaneValue >= 116 && vaneValue <= 155)
  { // SE
    directionValue = 8;
  }
  else if (vaneValue >= 156 && vaneValue <= 190)
  { // SSW
    directionValue = 14;
  }
  else if (vaneValue >= 191 && vaneValue <= 270)
  { // S
    directionValue = 4;
  }
  else if (vaneValue >= 271 && vaneValue <= 335)
  { // NNE
    directionValue = 10;
  }
  else if (vaneValue >= 336 && vaneValue <= 450)
  { // NE
    directionValue = 5;
  }
  else if (vaneValue >= 451 && vaneValue <= 510)
  { // WSW
    directionValue = 13;
  }
  else if (vaneValue >= 511 && vaneValue <= 570)
  { // SW
    directionValue = 7;
  }
  else if (vaneValue >= 571 && vaneValue <= 660)
  { // NNW
    directionValue = 11;
  }
  else if (vaneValue >= 661 && vaneValue <= 730)
  { // N
    directionValue = 2;
  }
  else if (vaneValue >= 731 && vaneValue <= 805)
  { // WNW
    directionValue = 12;
  }
  else if (vaneValue >= 806 && vaneValue <= 870)
  { // NW
    directionValue = 6;
  }
  else if (vaneValue >= 871 && vaneValue <= 1023)
  { // W
    directionValue = 3;
  }
  else
  {
    directionValue = 0;
  }
  return directionValue;
}

void inputs()
{
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
  if (vaneAverageCounter >= vaneSamples)
  {
    //displayedVaneAverage = mean(vaneAverage, vaneAverageCounter), DEC;
    displayedVaneAverage = vaneValue;
    vaneAverageCounter = 0;
  }
  else
  {
    vaneAverage[vaneAverageCounter] = atoi(vaneDegrees[directionValue]);
    vaneAverageCounter++;
  }

  ///////////////////////// anemometer - wind speed
  if (anemometerState != lastAnemometerState && anemometerState == HIGH)
  { // if we have received a pulse
    anemometerPulses++;
    blinkRedLed = true;
  }
  lastAnemometerState = anemometerState; // save state to next run

  if (currentMillis - anemometerMillis >= 10000)
  {
    //anemometerPulsesPerSecond = anemometerPulses;
    windSpeed = anemometerPulses * 0.667 / 10; // one pulse is 0.667 m/s
    anemometerPulses = 0;
    anemometerMillis = currentMillis;
    windSpeedAverage += windSpeed;
    windSpeedAverageCounter++;
  }

  ///////////////////////// rain gauge - tip bucket
  if (rainBucketState != lastrainBucketState && rainBucketState == HIGH)
  { // if we have received a pulse
    rainBucketTips++;
    totalRain += 0.279; // one pulse is 0.279 mm of rain
    rainSinceLastPoll += 0.279;
    rainIntensity = 60 * 0.279 / ((currentMillis - lastRainMillis) / 1000);
    lastRainMillis = currentMillis;
    blinkRedLed = true;
  }
  lastrainBucketState = rainBucketState; // save state for next run

  if ((currentMillis - lastRainMillis) > 60000)
  { // if we haven't received a puse for 60 seconds, set intensity to 0
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
}
