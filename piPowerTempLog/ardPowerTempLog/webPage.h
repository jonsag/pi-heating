/*******************************
  Present webpage
*******************************/
void presentWebPage(void) {
  EthernetClient client = server.available(); // listen for incoming clients
  if (client) {
    digitalWrite(greenPinNetwork, HIGH); // turn green LED on
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        if (readString.length() < 100) { //read char by char HTTP request
          readString += c; //store characters to string
        }
        if (c == '\n') { //if HTTP request has ended
          Serial.println(readString); //print to serial monitor for debuging

          //now output HTML data header
          if (readString.indexOf('?') >= 0) { //don't send new page
            client.println("HTTP/1.1 204 JS Arduino");
            client.println();
            client.println();
          }
          else {

            // headers
            client.println("HTTP/1.1 200 OK"); //send new page
            client.println("Content-Type: text/html");
            client.println();
            client.println("<HTML>");
            client.println("<HEAD>");
            client.println("<TITLE>Arduino logger</TITLE>");
            client.println("</HEAD>");
            client.println("<BODY>");
            client.println("<H1>ardPowerTempLog</H1>");

            // currents
            client.println("<br>");
            for (phaseCount = 0; phaseCount <= 2; phaseCount++) {
              client.print("Current phase ");
              client.print(phaseCount + 1);
              client.print(": ");
              client.print(displayedCurrent[phaseCount]);
              //client.print(current[i]);
              client.println(" A<br>");
            }
            client.println("<br>");
            for (phaseCount = 0; phaseCount <= 2; phaseCount++) {
              client.print("Current average phase ");
              client.print(phaseCount + 1);
              client.print(": ");
              client.print(polledCurrent[phaseCount]);
              client.println(" A<br>");
            }
            client.print("Based on ");
            client.print(currentPollCounter);
            client.println(" values<br>");
            client.print("Polled ");
            client.print(pollAge / 1000);
            client.println(" seconds ago");
            client.println("<br><br>");

            // temps
            for (tempsCounter = 0; tempsCounter < numberOfSensors; tempsCounter++) {
              client.print("Temperature sensor ");
              client.print(tempsCounter);
              client.print(": ");
              client.print(tempValue[tempsCounter]);
              client.println(" C<br>");
            }
            client.print("Temps read ");
            client.print(tempAge / 1000);
            client.println(" seconds ago<br>");
            client.println("<br>");

            // pulses
            client.print("Pulses last poll: ");
            client.print(pulsesLastPoll);
            client.println("<br>");
            client.print("Pulses since last poll: ");
            client.print(pulses);
            client.println("<br>");

            client.println("<br>");
            client.println("<a href=\"/?pulse\" target=\"inlineframe\">Send pulse</a><br>");
            client.println("<IFRAME name=inlineframe style=\"display:none\" >");
            client.println("</IFRAME><br>");
            client.println("</BODY>");
            client.println("</HTML>");
          }

          ///////////////////// check if we should add a pulse
          if (readString.indexOf("pulse") > 0) { //checks for click simulating a pulse
            pulses++;
            Serial.print("Pulse from webpage, pulses this interval is now ");
            Serial.println(pulses);
            blinkRed = true;
          }

          ///////////////////// check if this is a poll
          if (readString.indexOf("pollReset") > 0) { //checks for poll reset
            //Serial.println("---Recieved pollReset, will reset pulses and average current values");
            Serial.println("---Recieved pollReset");
            pollMillis = currentMillis;
            pulsesLastPoll = pulses;
            pulses = 0;
            currentPollCounter = 0;
            for (phaseCount = 0; phaseCount <= 2; phaseCount++) {
              ackPolledCurrent[phaseCount] = 0;
            }
          }

          ///////////////////// check if we should read temps
          if (readString.indexOf("readTemps") > 0) { //will read 1-wire temps
            getTemperatures();
          }
          readString = ""; //clearing string for next read
          delay(100);
          client.stop(); //stopping client
          digitalWrite(greenPinNetwork, HIGH); // turn green LED on
        }
      }
    }
  }
} // end of web page
