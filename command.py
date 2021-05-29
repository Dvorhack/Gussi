import socket
import sys


HOST = '127.0.0.1'
PORT = 8081
s = socket.socket()
s.connect((HOST, PORT))

if(len(sys.argv) != 2):
    print("Usage: %s 'command'".format(sys.argv[0]))

msg = sys.argv[1]
#print(msg)
s.send(msg.encode())
s.close()
