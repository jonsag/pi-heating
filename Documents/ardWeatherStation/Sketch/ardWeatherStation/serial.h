/////////////////////////////// print  complete output to serial ///////////////////////////////
void serialPrintComplete() {
  if (currentMillis - serialPrintMillis >= 1000) {
    //Serial.print(currentMillis);
    //Serial.print("    ");

    //Serial.print(vaneValue);
    //Serial.print("    ");
    Serial.print("Wind direction: ");
    Serial.print(vaneDirection[directionValue]);
    Serial.print("    ");
    Serial.print(vaneDegrees[directionValue]);
    Serial.print("    ");

    //Serial.print(anemometerState);
    //Serial.print("    ");
    //Serial.print(anemometerPulsesPerSecond);
    //Serial.print("    ");
    Serial.print("Wind speed: ");
    Serial.print(windSpeed);
    Serial.print(" m/s    ");
    Serial.print("Average wind speed: ");
    if (windSpeedAverageCounter != 0) {
      Serial.print(windSpeedAverage / windSpeedAverageCounter);
    }
    else {
      Serial.print(windSpeedAverage);
    }
    Serial.print(" m/s    ");
    Serial.print(",");
    Serial.print("Rain intensity: ");
    Serial.print(rainIntensity);
    Serial.print(" mm/min    ");
    //Serial.print(rainBucketState);
    //Serial.print("    ");
    //Serial.print(rainBucketTips);
    //Serial.print("    ");
    Serial.print("Rain total: ");
    Serial.print(totalRain);
    Serial.print(" mm    ");
    //Serial.print(currentMillis - lastRainMillis);
    //Serial.print("    ");

    Serial.println();

    //serialPrintMillis = currentMillis;
  }
}

/////////////////////////////// help ///////////////////////////////
void help() {
  Serial.println("---------- help ----------");
  Serial.println("Enter c for complete output");
  Serial.println("Enter p to simulate a poll");
  Serial.println("Enter e to explain poll output");
  //Serial.println("Enter s to simulate rain");
  Serial.println("Enter r to reset rain since last poll");
  //Serial.println("Enter R to reset rain total");
  Serial.println("Enter h for this help");
  Serial.println("--------------------------");
  Serial.println();
}

/////////////////////////////// poll ///////////////////////////////
void poll() {
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
  if (windSpeedAverageCounter != 0) {
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

/////////////////////////////// explain ///////////////////////////////
void explain() {
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

/////////////////////////////// reset values after poll ///////////////////////////////
void resetAll() {
  rainSinceLastPoll = 0;
  windSpeedAverage = 0;
  windSpeedAverageCounter = 0;
  Serial.println("Values reset");
}

void serial() {

  ///////////////////// check serial for message
  if (Serial.available()) { // check if data has been sent from the computer
    byteRead = Serial.read(); // read the most recent byte
    if ( byteRead == 99 ) { // c outputs complete information
      serialPrintComplete();
    }
    else if ( byteRead == 104 ) { // h outputs help info
      help();
    }
    else if ( byteRead == 112 ) { // p does a poll
      poll();
    }
    else if ( byteRead == 101 ) { // e explains polling output
      explain();
    }
    /*
      else if ( byteRead == 115 ) { // s simulates rain
      totalRain += 0.279; // one pulse is 0.279 mm of rain
      rainSinceLastPoll += 0.279;
      }
    */
    else if ( byteRead == 114 ) { // r resets rain since last poll
      resetAll();
    }
    /*
      else if ( byteRead == 82 ) { // R resets rain total
      totalRain = 0;
      }
    */
    else {
      Serial.write(byteRead);
      Serial.println(" NA");
      Serial.println();
    }
  }
}
