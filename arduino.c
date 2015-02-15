#define LEDS 4
#define irSensorPin A0
#define irLedPin 9

#define _log(a) Serial.println((a))
#define __log(a) Serial.print((a))

const int led[LEDS] = {7, 6, 5, 4};      // the pin that the LED is attached to
int ledState[LEDS] = {0};

// For IR Reader
#define timeCount 20
#define Multiplier 5000
#define trhld 700
float val = 0;
int zeroSince = 0;
float irRead(int readPin, int triggerPin); //function prototype

void setup()
{
  pinMode(irSensorPin, INPUT);
  // initialize the serial communication:
  Serial.begin(9600);
  // initialize the ledPin as an output:
  for(int i = 0; i < LEDS; i++)
    pinMode(led[i], OUTPUT);
  Serial.flush();
}

void loop() {
  float irval = irRead(irSensorPin, irLedPin);
  val += (irval > 20) ? irval : 0;
  if (val > trhld * Multiplier) {
    ledState[0] = (ledState[0] == 1) ? 0 : 1;
    if (ledState[0] == 1) {
      Serial.println("ON -- ");
      digitalWrite(led[0], HIGH);
      delay(1000);
    } else {
      Serial.println("OFF -- ");
      digitalWrite(led[0], LOW);
      delay(1000);
    }
    val = 0;
  } else {
    // reseting val
    if (irval <= 20) {
      zeroSince++;
      if (zeroSince == 50) {
        Serial.println("Value reset");
        zeroSince = 0;
        val = 0;
      }
    }
    else {
      zeroSince = 0;
      Serial.print(val*100 / (trhld * Multiplier));
      Serial.println("%");
    }
  }
  //----------------------
  
  
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
    _log("------------------------------");
    _log(input);
    for(int i = 0; i < LEDS; i++) {
      if ((input>>i)&1 == 1) {
        digitalWrite(led[i], HIGH);
        ledState[i] = 1;
        __log(i);
        __log(" HIGH\n");
      } else {
        digitalWrite(led[i], LOW);
        ledState[i] = 0;
      }
    }
  }
  delay(10);
  return;
}

/******************************************************************************
 * This function can be used with a panasonic pna4602m ir sensor
 * it returns a zero if something is detected by the sensor, and a 1 otherwise
 * The function bit bangs a 38.5khZ waveform to an IR led connected to the
 * triggerPin for 1 millisecond, and then reads the IR sensor pin to see if
 * the reflected IR has been detected
 ******************************************************************************/
float irRead(int readPin, int triggerPin)
{
  int halfPeriod = 13; //one period at 38.5khZ is aproximately 26 microseconds
  int cycles = 38; //26 microseconds * 38 is more or less 1 millisecond
  int i;
  for (i=0; i <=cycles; i++)
  {
    digitalWrite(triggerPin, HIGH); 
    delayMicroseconds(halfPeriod);
    digitalWrite(triggerPin, LOW); 
    delayMicroseconds(halfPeriod - 1);     // - 1 to make up for digitaWrite overhead    
  }
  return analogRead(readPin);
}