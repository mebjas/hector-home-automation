#include <Ethernet.h>
#include <SPI.h>

#define _log(a) Serial.println((a))

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
//78:31:c1:cd:8e:f6
byte mac[] = {  
  0x78, 0x31, 0xC1, 0xCD, 0x8E, 0xF6 };

// Initialize the Ethernet client library
// with the IP address and port of the server 
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;
int gotIp = 1;

void setup() {
  Serial.begin(9600);
  _log("Serial not connected yet");
  while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  }
  _log("Serial connected");

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore
    gotIp = 0;
  }
  
  // print your local IP address:
  Serial.print("My IP address: ");
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    // print the value of each byte of the IP address:
    Serial.print(Ethernet.localIP()[thisByte], DEC);
    Serial.print("."); 
  }
  Serial.println();
}

int x = 0;
void loop() {
  if (!x) {
    x = 1;
    if (gotIp) _log("Got IP YEY");
    else _log("Didn't get IP");
  }
}

