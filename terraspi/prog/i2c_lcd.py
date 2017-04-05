#! /usr/bin/env python
#-*- coding: utf-8 -*-

#    I2C_LCD
# 5v au 5v du pi
# GND au GND du pi
# SCL sur SCL1 du pi
# SDA sur SDA1 du pi

import I2C_LCD_driver
import time
import RPi.GPIO as GPIO
import Adafruit_DHT

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM) 

pin = 19

GPIO.setup(pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)

dateheure = time.strftime('%Y-%m-%d %H:%M',time.localtime())
mylcd = I2C_LCD_driver.lcd()

mylcd.lcd_display_string("%s" %dateheure, 1)
mylcd.lcd_display_string("Init ok", 2)
time.sleep(3)
mylcd.lcd_clear()
mylcd.backlight(0)

def main():
	dateheure = time.strftime('%Y-%m-%d %H:%M',time.localtime())
	mylcd.backlight(1)
	mylcd.lcd_display_string("Initialisation..", 2)
	humF, tempF = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 22)   
	humC, tempC = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 27)    
	humF = round(humF,2)                   
	tempF = round(tempF,2)
	humC = round(humC,2)
	tempC = round(tempC,2)
	mylcd.lcd_clear()
	mylcd.lcd_display_string("%s" %dateheure, 1)
	mylcd.lcd_display_string("Hello you !!!", 2)
	time.sleep(3)
	mylcd.lcd_clear()
	mylcd.lcd_display_string("%s" %dateheure, 1)
	mylcd.lcd_display_string("Point chaud :", 2)
	time.sleep(2)
	mylcd.lcd_clear()
	mylcd.lcd_display_string('Temp= %s deg C' %tempC, 1)
	mylcd.lcd_display_string('Humi= %s / 100' %humC , 2)	
	time.sleep(5)
	mylcd.lcd_clear()
	mylcd.lcd_display_string("%s" %dateheure, 1)
	mylcd.lcd_display_string("Point froid :", 2)
	time.sleep(2)
	mylcd.lcd_clear()
	mylcd.lcd_display_string('Temp= %s deg C' %tempF, 1)
	mylcd.lcd_display_string('Humi= %s / 100' %humF , 2)	
	time.sleep(5)
	mylcd.lcd_clear()
	mylcd.lcd_display_string("%s" %dateheure, 1)
	mylcd.lcd_display_string("Bye-bye you !!!", 2)
	time.sleep(3)
	mylcd.lcd_clear()
	mylcd.backlight(0)

while True:
	entree = GPIO.input(pin)   #lecture de l'état du bouton
	if (entree == True):       #si touche appuyee
		main()			

    
