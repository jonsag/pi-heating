/*******************************
  Blink LEDs
*******************************/
void blinkLEDs(void)
{
  /*if (blinkYellow && blinkYellowCounter < 20) {
    blinkYellowCounter++;
    digitalWrite(yellowPinTemp, HIGH);
    }
    else {
    blinkYellow = false;
    blinkYellowCounter = 0;
    digitalWrite(yellowPinTemp, LOW);
    }

    if (!blinkYellow && blinkYellowOffCounter < 10000) {
    blinkYellowOffCounter++;
    }
    else {
    blinkYellow = true;
    blinkYellowOffCounter = 0;
    }*/

  if (blinkGreen && blinkGreenCounter < 20)
  {
    blinkGreenCounter++;
    digitalWrite(greenPinNetwork, HIGH);
  }
  else
  {
    blinkGreen = false;
    blinkGreenCounter = 0;
    digitalWrite(greenPinNetwork, LOW);
  }

  if (blinkRed && blinkRedCounter < 20)
  {
    blinkRedCounter++;
    digitalWrite(redPinPulse, HIGH);
  }
  else
  {
    blinkRed = false;
    blinkRedCounter = 0;
    digitalWrite(redPinPulse, LOW);
  }
}
