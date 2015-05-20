from BaseHTTPServer import BaseHTTPRequestHandler, HTTPServer
import SocketServer
import re
import serial

ser = serial.Serial('/dev/tty.usbmodem1421', 9600)
 
class S(BaseHTTPRequestHandler):
    def _set_headers(self):
        self.send_response(200)
        self.send_header('Content-type', 'text/html')
        self.end_headers()
 
    def do_GET(self):
        self._set_headers()
        print '--------------------------------------------------------------------------'
        print 'request recieved from the client ' +self.client_address[0] +':' +str(self.client_address[1])
        print 'request recieved for the path ' +self.path
        m = re.search('.*data=(\d*).*', self.path)
        print 'attempting to connect to arduino'
        print 'connection successful, sending data'
        ser.write(m.group(1))
        print 'send data sccessfull'
        print 'examining the result'
        print '--------------------'
        k = int(m.group(1))
        for x in range(0, 4):
            if (k&(1<<x)):
                print '[' +str(x+1) +'] => HIGH'
            else:
                print '[' +str(x+1) +'] => LOW'
        # self.send_header('X-Minhaz-Says', 'success')

 
    def do_HEAD(self):
        self._set_headers()
        
    def do_POST(self):
        # Doesn't do anything with posted data
        self._set_headers()
        print 'POST request not supported'
        
def run(server_class=HTTPServer, handler_class=S, port=10110):
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    print 'Starting httpd...'
    httpd.serve_forever()
 
if __name__ == "__main__":
    from sys import argv
 
    if len(argv) == 2:
        run(port=int(argv[1]))
    else:
        run()