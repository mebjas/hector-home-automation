#include <stdio.h>
#include <iostream>
using namespace std;

#define COMM "/dev/tty.usbmodem1421"
#define LEDS 4

int main(int argc, char *argv[]) {
	bool state[LEDS] = {false};
	int out = 0;

	if (argc != 2) {
		cout<<"1003"<<endl;
		return 0;
	}
	int i = 0;
	while(argv[1][i] != '\0' && i < LEDS) {
		if (argv[1][i] == 'o' || argv[1][i] == 'O') {
			state[i] = true;
			out |= 1<<i;
		}
		++i;
	}
	
	i = 0;
	while(i < LEDS) {
		cout<<"LED - "<<i<<" ";
		if (state[i]) cout<<"ON";
		else cout<<"OFF";
		cout<<endl;
		++i;
	}

	FILE *file;
    file = fopen(COMM, "w");
    if (!file) {
    	cout<<"1001"<<endl;
    	return 0;
    }
    fprintf(file, "%d", out);
    fclose(file);
}