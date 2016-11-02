#! /usr/bin/env python
#-*- coding: utf-8 -*-

# import des librairies
import time
import RPi.GPIO as GPIO
import Adafruit_DHT
from RPLCD import CharLCD, cleared, cursor, BacklightMode
GPIO.setwarnings(False)

pin = 19

degres = (
    0b11100,
    0b10100,
    0b11100,
    0b00000,
    0b00000,
    0b00000,
    0b00000,
    0b00000
)

coeur = (
    0b00000,
    0b00000,
    0b01010,
    0b11111,
    0b11111,
    0b01110,
    0b00100,
    0b00000
)

tete = (
    0b10001,
    0b01010,
    0b11111,
    0b10101,
    0b11111,
    0b10101,
    0b10001,
    0b01110
)

corpsbas = (
    0b00000,
    0b00000,
    0b01110,
    0b11111,
    0b11011,
    0b11011,
    0b11111,
    0b01110
)

corpshaut = (
    0b01110,
    0b11111,
    0b11011,
    0b11011,
    0b11111,
    0b01110,
    0b00000,
    0b00000
)




def main():
    
    #   on lit les sondes  
    
    #   point froid 
    humidity, temperature = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 22)
    #  point chaud 
    humidityC, temperatureC = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 27)
    
    # on arrondi a 2 chiffres   
    humidity = round(humidity,2)                   
    temperature = round(temperature,2)
    humidityC = round(humidityC,2)
    temperatureC = round(temperatureC,2)
    
    lcd = CharLCD(cols=16, rows=2,

                pin_rw=None,

                pin_rs=7,

                pin_e=8,

                pins_data=[25,24,23,18],
                
                pin_backlight=13,
                
                backlight_enabled=True,               

                numbering_mode=GPIO.BCM)


    with cleared(lcd):
          lcd.create_char(2, tete)
          lcd.create_char(3, corpsbas)
          lcd.create_char(4, corpshaut)       
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(2))
          lcd.write_string(u'  ')
          lcd.write_string(unichr(2))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
         
    with cursor(lcd, 1, 0):
          lcd.create_char(1, coeur)     
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))         
          lcd.write_string(u'  Salut ! ')         
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))
         
    time.sleep (4);      
    
        
    with cleared(lcd):
         lcd.write_string(u'Point chaud :')
         
         
    with cursor(lcd, 1, 0):
         lcd.write_string(u' Temp = %s ' %temperatureC)
         lcd.create_char(0, degres)
         lcd.write_string(unichr(0))
         lcd.write_string(u'C')
         
    time.sleep (5);
    
    with cleared(lcd):
         lcd.write_string(u'Point chaud :')
    
    with cursor(lcd, 1, 0):
         lcd.write_string(u' Humi = %s ' %humidityC)
         lcd.write_string(u'%')
         
    time.sleep (5);
    
    with cleared(lcd):
         lcd.write_string(u'Point froid :')
         
         
    with cursor(lcd, 1, 0):
         lcd.write_string(u' Temp = %s ' %temperature)
         lcd.create_char(0, degres)
         lcd.write_string(unichr(0))
         lcd.write_string(u'C')
         
    time.sleep (5);
    
    with cleared(lcd):
         lcd.write_string(u'Point froid :')
    
    with cursor(lcd, 1, 0):
         lcd.write_string(u' Humi = %s ' %humidity)
         lcd.write_string(u'%')
         
    time.sleep (5);
    
    with cleared(lcd):
          lcd.create_char(2, tete)
          lcd.create_char(3, corpsbas)
          lcd.create_char(4, corpshaut)       
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(2))
          lcd.write_string(u'  ')
          lcd.write_string(unichr(2))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
          lcd.write_string(unichr(4))
          lcd.write_string(unichr(3))
         
    with cursor(lcd, 1, 0):
          lcd.create_char(1, coeur)     
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))         
          lcd.write_string(u' Bye-bye ! ')        
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))
          lcd.write_string(unichr(1))
          
    time.sleep (4);

    lcd.close(clear=True)

# on lance la boucle
try:
 while True: 
     GPIO.setmode(GPIO.BCM)   
     GPIO.setup(pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
     from RPLCD import CharLCD, cleared, cursor, BacklightMode
     entree = GPIO.input(pin)   #lecture de l'état du bouton
     if (entree == True):       #si touche appuyee
         main()                 # on lance la fonction main
         time.sleep(1.0)

except KeyboardInterrupt:          #sortie boucle par ctrl-c
 GPIO.cleanup()                 #libere toutes les ressources



