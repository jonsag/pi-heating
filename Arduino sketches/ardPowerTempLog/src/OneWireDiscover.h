/*******************************
  Discover sensors
*******************************/
int discoverOneWireDevices(void)
{
  digitalWrite(yellowPinTemp, HIGH); // turn yellow LED on

  while (oneWire.search(addr))
  {
    Serial.print("Found \'1-Wire\' device with address: ");
    for (i = 0; i < 8; i++)
    {
      Serial.print("0x");
      if (addr[i] < 16)
      {
        Serial.print('0');
      }
      Serial.print(addr[i], HEX);
      if (i < 7)
      {
        Serial.print(", ");
      }
    }
    if (OneWire::crc8(addr, 7) != addr[7])
    {
      Serial.println("CRC is not valid!");
      return 0;
    }
    Serial.println();
    count++;
  }
  oneWire.reset_search();
  return count;
  digitalWrite(yellowPinTemp, LOW); // turn yellow LED off
}
