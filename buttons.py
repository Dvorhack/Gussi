from gpiozero import LED, Button
import os

led = LED(17)
button = Button(23)

"""while True:
    if button.is_pressed:
        led.on()
    else:
        led.off()"""

def clicked():
    led.on()
    print("appuyé")
    os.system("python3 /home/pi/site/command.py next")

def released():
    led.off()
    print("relaché")


button.when_pressed = clicked
button.when_released = released

while True:
    pass
