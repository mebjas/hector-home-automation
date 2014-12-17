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
  int input = 0;
  int selected, state;
  int flag = 0;
  
  // Read any serial input
  while (Serial.available() > 0)
  {
    input = (input*10) + ((char) Serial.read() - '0'); // Read in one char at a time
    ++flag;
    delay(5); // Delay for 5 ms so the next char has time to be received
  }
  if (flag) {
    Serial.println("------------------------------");
    Serial.println(input);
    for(int i = 0; i < LEDS; i++) {
      if ((input>>i)&1 == 1) {
        digitalWrite(led[i], HIGH);
        Serial.print(i);
        Serial.print(" HIGH\n");
      } else {
        digitalWrite(led[i], LOW);
      }
    }
  }
  return;
}