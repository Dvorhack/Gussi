#!/usr/bin/env python3

from omxplayer.player import OMXPlayer
from pathlib import Path
from time import sleep
import socket
import os, sys, random


MAX_LENGTH = 4096
AUDIO_PATH = "/home/pi/site/sounds/"

serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

PORT = 8081
HOST = '0.0.0.0'

serversocket.bind((HOST, PORT))
serversocket.listen()

#player = OMXPlayer(AUDIO_PATH + os.listdir(AUDIO_PATH)[0], pause=True)


while 1:
    
    #accept connections from outside
    (clientsocket, address) = serversocket.accept()

    buf = clientsocket.recv(MAX_LENGTH).decode('utf-8').split(" ")
    musiques = os.listdir(AUDIO_PATH)
    
    if buf[0] == 'quit':
        if player in locals():
            try:
                player.quit()
            except:
                pass
    
    elif buf[0] == 'play':
        if 'player' in locals():
            try:
                player.play_pause()
            except:
                pass
    
    elif buf[0] == 'pause':
        if 'player' in locals():
            try:
                player.play_pause()
            except:
                pass
    
    elif buf[0] == 'next':
        if 'player' in locals():
            player.load(AUDIO_PATH + musiques[random.randint(0,len(musiques)-1)])
        else:
            player = OMXPlayer(AUDIO_PATH + musiques[random.randint(0,len(musiques)-1)])
    
    elif buf[0] == 'prev':
        if 'player' in locals():
            try:
                player.previous()
            except:
                pass
    
    elif buf[0] == 'vol':
        if 'player' in locals():
            try:
                player.set_volume(float(buf[1]))
            except:
                pass

    elif buf[0] == 'time':
        if 'player' in locals():
            try:
                temps = player.duration()
                player.set_position(temps * float(buf[1])/100)
            except:
                pass
    
    elif buf[0] == 'new':
        if 'player' in locals():
            player.load(AUDIO_PATH + buf[1])
        else:
            player = OMXPlayer(AUDIO_PATH + buf[1])
        """try:
            player.quit()
        except:
            print("LE player était déja arrêté")
            print("Unexpected error:", sys.exc_info()[0])
        
        if os.path.exists(AUDIO_PATH + buf[1]):
            player = OMXPlayer(AUDIO_PATH + buf[1])
        else:
            print("Le path: '" + AUDIO_PATH + buf[1] + "' n'existe pas !")"""

    print (buf)
    clientsocket.close()
