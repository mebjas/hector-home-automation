#define LEDS 4
const int led[LEDS] = {2, 3, 4, 5};      // the pin that the LED is attached to

void setup()
{
  // initialize the serial communication:
  Serial.begin(9600);
  // initialize the ledPin as an output:
  for(int i = 0; i < LEDS; i++)
    pinMode(led[i], OUTPUT);
  Serial.flush();
}

void loop() {
  char input;
  int selected, state;
  int flag = 0;
  
  // Read any serial input
  while (Serial.available() > 0)
  {
    input = (char) Serial.read(); // Read in one char at a time
    Serial.println(input);
    selected = (input - 'a') / 2;
    state = (input - 'a') % 2;  // 0 - off, 1 - on
    ++flag;
    Serial.println("LED: " +selected +' , STATE: ' +state);
    delay(5); // Delay for 5 ms so the next char has time to be received
  }
  
  if (flag) {
    if (selected >= 0 && selected < LEDS) {
      if (state == 1)
        digitalWrite(led[selected], HIGH);
      else if (state == 0)
        digitalWrite(led[selected], LOW);
    }
  }
}

  