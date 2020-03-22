
void serial(void) {

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
    }
  }
}

/////////////////////////////// print  complete output to serial ///////////////////////////////
void serialPrintComplete(void) {
  if(currentMillis - serialPrintMillis >= 1000) {
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
    if(windSpeedAverageCounter != 0) {
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
