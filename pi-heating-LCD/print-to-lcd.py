#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import getopt, sys, time

from datetime import datetime

from modules import (db_connect, db_disconnect, db_query, initialize_lcd, print_to_LCD, 
                     onError, usage, random_chars)

try:
    myopts, args = getopt.getopt(sys.argv[1:],
                                 'l'
                                 'vh',
                                 ['11', 'line1=', 'line2=', 'light', 'verbose', 'help'])

except getopt.GetoptError as e:
    onError(1, str(e))
    
if len(sys.argv) == 1:  # no options passed
    onError(2, 2)
    
light = False
line_1 = ""
line_2 = ""
button_1 = False
verbose = False
    
for option, argument in myopts:     
    if option in ('-l', '--light'):  # turn backlight on
        light = True
    elif option == '--line1':  # first line of LCD
        line_1 = argument
    elif option == '--line2':  # second line of LCD
        line_2 = argument
    elif option == '--11':  # button 11 - light LCD
        button_1 = True
    elif option in ('-v', '--verbose'):  # verbose output
        verbose = True
    elif option in ('-h', '--help'):  # display help text
        usage(0)

if verbose:
    i = 1
    print "+++ Script run with:"
    for option, argument in myopts:     
        print "        Option %s: %s" % (i, option)
        print "        Argument %s: %s" % (i, argument)
        i += 1
        
#load lcd
if verbose:
    print "+++ Initializing LCD..."
lcd, lcd_wake_time, lcd_columns  = initialize_lcd()

# connect to database
if verbose:
    print "+++ Connecting to db..."
cnx, cursorread = db_connect()

# button 1 - light LCD
if button_1:
    light = True
    if verbose:
        print "+++ Button 1 pressed"

# get first temperature
query = "SELECT value FROM sensors LIMIT 1"
results = db_query(cursorread, query)
temp = results[0][0]
    
#line_1 = datetime.now().strftime('%b %d %H:%M') # mon d h:m
#line_1 = datetime.now().strftime('%d/%m %H:%M') # dd/mm h:m

if not line_1:
    line_1 = "%s %s" % (datetime.now().strftime('%d/%m %H:%M'), temp)
if not line_2:
    line_2 = "Hej, hej Monica!"
    line_2 = random_chars()

if light:   
    # clear screen and turn backlight on
    lcd.clear()
    lcd.set_backlight(1)
    if verbose:
        print "--- Backlight ON"
    
    # print to LCD
    print_to_LCD(lcd, 0, 0, "1", line_1, lcd_columns, verbose)
    print_to_LCD(lcd, 0, 1, "2", line_2, lcd_columns, verbose)

    if verbose:
        print "--- Wait %ss..." % lcd_wake_time
    time.sleep(lcd_wake_time)
        
    # clear screen and turn backlight off.
    lcd.clear()
    lcd.set_backlight(0)
    if verbose:
        print "--- Backlight OFF"

# close db
if verbose:
    print "+++ Disconnecting from db..."
db_disconnect(cnx, cursorread)




