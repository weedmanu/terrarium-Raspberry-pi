#!/usr/bin/env python
#-*- coding: utf-8 -*-

# import des librairies

import time
import RPi.GPIO as GPIO
import Adafruit_DHT
from RPLCD import CharLCD, cleared, cursor, BacklightMode
GPIO.setwarnings(False)


# on défini l'écran 16x2 et les gpio  
lcd = CharLCD(cols=16, rows=2,

            pin_rw=None,

            pin_rs=7,

            pin_e=8,

            pins_data=[25,24,23,18],
            
            pin_backlight=13,
            
            backlight_enabled=True,               

            numbering_mode=GPIO.BCM)

# on dit coucou
with cleared(lcd):            
    lcd.write_string(u'  Salut ! ') 

time.sleep (15);
          
# on ferme en effaçant              
lcd.close(clear=True)

# on libére les gpio
GPIO.cleanup()           


