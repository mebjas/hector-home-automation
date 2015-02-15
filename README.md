hector-home-automation
======================

Project Hector: smart home automation and telemetry

##Current state
Capable of controlling the LEDS using `tablet`, `phone`, `web browser`, `terminal` or `serial monitor - Arduino`!

`Arduino code` runs in the mega board that:
 - Controls the LEDS
 - Recieves the Serial inputs
 - Send back Serial Acknoledgements

`C++ binary` is capable of sending serial data to arduino connected to `tty.usbmodem1421` interface currently hardcoded for my macintosh
![c++ binary](http://cistoner.org/minhaz/wp-content/uploads/2014/12/Screen-Shot-2014-12-17-at-8.20.35-pm-1024x207.png)

`php server` is for recieving data from client and executing the c++ binary

`html client` is for:
 - Switching LEDS On or Off
 - Get Information about state of leds

![web interface](http://cistoner.org/minhaz/wp-content/uploads/2015/01/Screen-Shot-2015-01-13-at-12.21.57-pm-1024x358.png)
