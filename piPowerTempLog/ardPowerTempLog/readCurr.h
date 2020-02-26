/*******************************
  Read currents
*******************************/
void readCurrents(void) {
  if (currentDisplayedCounter < readAverageCounter) {
    for (phaseCount = 0; phaseCount <= 2; phaseCount++) {
      currentReading = analogRead(phase[phaseCount]);

      if (phaseCount == 0) {
        currentReading = (currentReading - 511) * 0.33; // compensate for phase 1
      }
      else if (phaseCount == 1) {
        currentReading = (currentReading - 511) * 0.33; // compensate for phase 2
      }
      else {
        currentReading = (currentReading - 510) * 0.33; // compensate for phase 3
      }
      
      ackDisplayedCurrent[phaseCount] = ackDisplayedCurrent[phaseCount] + abs(currentReading);
    }
    
    currentDisplayedCounter++;
  }
  else {
    Serial.print("Reading #");
    Serial.print(currentPollCounter);
    Serial.print("  ");
    for (phaseCount = 0; phaseCount <= 2; phaseCount++) {
      displayedCurrent[phaseCount] = ackDisplayedCurrent[phaseCount] / readAverageCounter; // set the displayed current value
      Serial.print(phaseCount);
      Serial.print(": ");
      Serial.print(displayedCurrent[phaseCount]);
      Serial.print(" A     ");
      ackDisplayedCurrent[phaseCount] = 0;
    }
    Serial.println();
    currentDisplayedCounter = 0;
    currentPollCounter++;

    for (phaseCount = 0; phaseCount <= 2; phaseCount++) {
      ackPolledCurrent[phaseCount] = ackPolledCurrent[phaseCount] + displayedCurrent[phaseCount]; // calculate an average for interval
      polledCurrent[phaseCount] = ackPolledCurrent[phaseCount] / currentPollCounter; // set the displayed current value
    }
  }
}
