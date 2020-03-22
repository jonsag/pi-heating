
/////////////////////////////// blinking rain LED ///////////////////////////////
void rainBlinking() {
  if (redLedOn && blinkMillis - currentMillis >= 200) {
    digitalWrite(redLed, LOW);
    redLedOn = false;
  }
  else if(blinkRedLed) {
    digitalWrite(redLed, HIGH);
    blinkMillis = currentMillis;
    blinkRedLed = false;
    redLedOn = true;
  }
}

/////////////////////////////// tick on lcd ///////////////////////////////
void tickPrint() {
  if(currentMillis - tickMillis > 2000) {
    tickMillis = currentMillis;
  }

  if(currentMillis - tickMillis > 1000) {
    tick = 219;
  }
  else {
    tick = 165;
  }

  if(tick != lastTick) {
    lcd.setCursor(19, 0);
    lcd.print((char)tick);
    //lcd.print(tick);
  }
  lastTick = tick;
}

/////////////////////////////// get length ///////////////////////////////
int getLength(int value) {
  int length;

  if(value > 9999)
    length = 5;
  else if(value > 999)
    length = 4;
  else if(value > 99)
    length = 3;
  else if(value > 9)
    length = 2;
  else
    length = 1;

  return length;
}

/////////////////////////////// print to LCD ///////////////////////////////
void lcdPrint(void) {
  //lcd.setCursor(0, 0);
  //lcd.print(currentMillis);

  if(currentMillis - lcdPrintMillis >= 1000) {
    ///// print wind
    lcd.setCursor(0, 1);
    lcd.print("   ");
    lcd.setCursor(0, 1);
    lcd.print(vaneDirection[directionValue]);

    //length = getLength(vaneDirection[directionValue]);
    lcd.setCursor(4, 1);
    lcd.print("   ");
    length1 = getLength(displayedVaneAverage);
    lcd.setCursor(7 - length1, 1);
    lcd.print(displayedVaneAverage);

    lcd.setCursor(7, 1);
    lcd.print((char)223);

    lcd.setCursor(12, 1);
    //windSpeed = 8.43;
    lcd.print(windSpeed);
    //length = 3 + getLength(windSpeed);

    ///// print rain
    lcd.setCursor(6, 2);
    lcd.print(totalRain);

    lcdPrintMillis = currentMillis;
  }
}

void outputs() {

    ///////////////////// blink
  if (blinkRedLed || redLedOn) { // if we should light led or if it's already lit
    rainBlinking();
  }

  ///////////////////// print
  lcdPrint();

  ///////////////////// erase status line
  if (currentMillis - pollMillis >= 1000 ) {
    lcd.setCursor(0, 3);
    lcd.print("                    ");
  }

  ///////////////////// life tick
  tickPrint();
  
}
