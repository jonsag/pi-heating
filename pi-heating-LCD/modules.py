#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import ConfigParser, os, sys

import Adafruit_CharLCD as LCD

config = ConfigParser.ConfigParser()  # define config file
config.read("%s/config.ini" % os.path.dirname(os.path.realpath(__file__)))  # read config file


def initialize_lcd():
    # read config for LCD
    lcd_rs = int(config.get('lcd', 'lcd_rs').strip(" "))
    lcd_en = int(config.get('lcd', 'lcd_en').strip(" "))
    lcd_d4 = int(config.get('lcd', 'lcd_d4').strip(" "))
    lcd_d5 = int(config.get('lcd', 'lcd_d5').strip(" "))
    lcd_d6 = int(config.get('lcd', 'lcd_d6').strip(" "))
    lcd_d7 = int(config.get('lcd', 'lcd_d7').strip(" "))
    lcd_backlight = int(config.get('lcd', 'lcd_backlight').strip(" "))

    lcd_columns = int(config.get('lcd', 'lcd_columns').strip(" "))
    lcd_rows = int(config.get('lcd', 'lcd_rows').strip(" "))
    
    # Initialize the LCD using the pins from config
    lcd = LCD.Adafruit_CharLCD(lcd_rs, lcd_en, lcd_d4, lcd_d5, lcd_d6, lcd_d7,
                           lcd_columns, lcd_rows, lcd_backlight)
    
    return lcd
    
    
def onError(errorCode, extra):
    print "\nError %s" % errorCode
    if errorCode in (1, 12):
        print extra
        usage(errorCode)
    elif errorCode == 2:
        print "No options given"
        usage(errorCode)
    elif errorCode in (3, 4, 5, 7, 8, 9, 10, 11, 13):
        print extra
        sys.exit(errorCode)
    elif errorCode in (6, 14):
        print extra
        return
        
def usage(exitCode):
    print "\nUsage:"
    print "----------------------------------------"
    print "%s -1 <text line 1> -2 <text line 2>" % sys.argv[0]
    print "\nMisc options:"
    print "-v    verbose output"
    print "-h    prints this"

    sys.exit(exitCode)
    
    
    
    
    
    
    

