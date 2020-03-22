

void inputs(void) {
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
    displayedVaneAverage = mean(vaneAverage, vaneAverageCounter), DEC;
    vaneAverageCounter = 0;
  }
  else {
    vaneAverage[vaneAverageCounter] = atoi(vaneDegrees[directionValue]);
    vaneAverageCounter++;
  }

  ///////////////////////// anemometer - wind speed
  if (anemometerState != lastAnemometerState && anemometerState == HIGH) { // if we have recieved a pulse
    anemometerPulses++;
    blinkRedLed = true;
  }
  lastAnemometerState = anemometerState; // save state to next run

  if (currentMillis - anemometerMillis >= 10000) {
    //anemometerPulsesPerSecond = anemometerPulses;
    windSpeed = anemometerPulses * 0.667 / 10; // one pulse is 0.667 m/s
    anemometerPulses = 0;
    anemometerMillis = currentMillis;
    windSpeedAverage += windSpeed;
    windSpeedAverageCounter ++;
  }

  ///////////////////////// rain gauge - tip bucket
  if (rainBucketState != lastrainBucketState && rainBucketState == HIGH) { // if we have recieved a pulse
    rainBucketTips++;
    totalRain += 0.279; // one pulse is 0.279 mm of rain
    rainSinceLastPoll += 0.279;
    rainIntensity = 60 * 0.279 / ((currentMillis - lastRainMillis) / 1000);
    lastRainMillis = currentMillis;
    blinkRedLed = true;
  }
  lastrainBucketState = rainBucketState; // save state for next run

  if ((currentMillis - lastRainMillis) > 60000) { // if we haven't recieved a puse for 60 seconds, set intensity to 0
    rainIntensity = 0;
  }

}
