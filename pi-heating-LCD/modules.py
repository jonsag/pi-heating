#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import os, sys, MySQLdb, time

import Adafruit_CharLCD as LCD

from ConfigParser import ConfigParser


def db_connect():
    dbconfig = ConfigParser()
    dbconfig.read('/home/pi/pi-heating-hub/config/config.ini')

    servername = dbconfig.get('db', 'server')
    username = dbconfig.get('db', 'user')
    password = dbconfig.get('db', 'password')
    dbname = dbconfig.get('db', 'database')

    cnx = MySQLdb.connect(host=servername, user=username, passwd=password, db=dbname)
    cnx.autocommit(True)
    cursorread = cnx.cursor()

    return cnx, cursorread


def db_disconnect(cnx, cursorread):
    cursorread.close()
    cnx.close()


def db_query(cursorread, query):
    cursorread.execute(query)
    results =cursorread.fetchall()
    
    return results


def initialize_lcd():
    config = ConfigParser()  # define config file
    config.read("%s/config.ini" % os.path.dirname(os.path.realpath(__file__)))  # read config file

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
    
    lcd_wake_time = int(config.get('lcd', 'lcd_wake_time').strip(" "))
    
    # Initialize the LCD using the pins from config
    lcd = LCD.Adafruit_CharLCD(lcd_rs, lcd_en, lcd_d4, lcd_d5, lcd_d6, lcd_d7,
                           lcd_columns, lcd_rows, lcd_backlight)
    
    return lcd, lcd_wake_time, lcd_columns


def print_to_LCD(lcd, cursor, row, line, message, lcd_columns, verbose):
    lcd.set_cursor(cursor, row) # insert text at column 0 and row 0
    
    orig_length = len(message)
    
    spaces = lcd_columns - orig_length
    
    if spaces > 0:
        message = message.ljust(16, ' ')
    if verbose:
        print "+++ Added %s space(s)" % spaces
        
    lcd.message(message)
    if verbose:
        print "Line %s: '%s' - %s" % (line, message, orig_length)
    if len(message) > lcd_columns:
        if verbose:
            print "--- Scrolling"
        for i in range(lcd_columns - orig_length):
            time.sleep(0.5)
            lcd.move_left()
            
            
def random_chars():
    import string
    import random
    
    count = random.randint(1, 16)
    
    message = ""
    for number in range(1, count):
        message = message + random.choice(string.letters)
        
    return message
    
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
    
    
    
    
    
    
    

